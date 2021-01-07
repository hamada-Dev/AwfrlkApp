<?php

namespace App\Http\Controllers\Api;

use App\Events\DeliveryNotifyEvent;
use App\Http\Resources\DeliveryRecourse;
use App\Http\Resources\OrderUserRecourse;
use App\Models\Area;
use App\Models\Order;
use App\Models\Promocode;
use App\Models\User;
use App\Models\UserOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{

    public $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userOrder = OrderUserRecourse::collection($this->model->where('client_id', auth()->user()->id)->get());
        if (!empty($userOrder))
            return $this->sendResponse($userOrder, 'order data');
        else
            return $this->sendError('300', 'there is no order for this user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get all active delivery 
        $ActiveDelivery = User::deliveryActive()->get();

        // check if user has promocode or not 
        $checkPromo = $this->checkUserPromo(auth()->user()->id);
        //  check if user has offer or not 
        $checkOffer = $this->checkUserOffer(auth()->user()->id);

        // this is for col type in order 
        $orderType = 0;

        if (!empty($checkPromo)) {
            $orderType = 2;
        } elseif (!empty($checkOffer)) {
            $orderType = 1;
        }

        if ($request->adress_from) {
            $request->validate([
                'area_id_from'   =>  ['required', 'numeric', 'exists:areas,id'],
                // 'area_id'        =>  ['required', 'numeric', 'exists:areas,id'],
                'product_home'   =>  ['required', 'string', 'max:254'],
                'adress_from'   =>  ['required', 'string', 'max:222'],
            ]);

            try {
                DB::beginTransaction();
                $deliveyPrice = $this->deliveryPriceHOHO($request, $orderType, $checkOffer, $checkPromo);
                $newOrder = $this->model->create([
                    'client_id'      =>  auth()->user()->id,
                    'area_id'        =>  $request->area_id ?? auth()->user()->area_id,
                    'adress'         =>  $request->adress ?? auth()->user()->adress,
                    'area_id_from'   =>  $request->area_id_from,
                    'adress_from'    =>  $request->adress_from,
                    'delivery_price' =>  $deliveyPrice['deliveryPrice'],
                    'offer_or_promo_id' =>  $deliveyPrice['offerOrPromoId'],
                    'type'           => $deliveyPrice['orderTyoe'],
                ]);

                $newOrder->orderDetails()->create([
                    'product_home' => $request->product_home,
                    'description'  => $request->description,
                ]);

                $this->makeEvent($newOrder, $ActiveDelivery);

                // this is update offer table or promocode 
                if ($deliveyPrice['offerOrPromoId'] != null) {
                    $this->updatePromoOffer($orderType, $checkOffer, $checkPromo);
                }

                DB::commit();
                return $this->sendResponse(['data' => 'add home order   sucessfully', 'Delivery' => DeliveryRecourse::collection($ActiveDelivery)], 200);
            } catch (\Exception $ex) {
                DB::rollback();
                return $this->sendError(['data' => 'cant add this order please try again'], 404);
            }
        } elseif ($request->image) {
            try {
                DB::beginTransaction();

                $newOrder = $this->insertOredr($request, $orderType, $checkOffer, $checkPromo);
                $this->uploadImage($request);
                $newOrder->orderDetails()->create([
                    'image'       => $request->image->hashName(),
                    'description' => $request->description,
                ]);

                // this is update offer table or promocode 
                if ($newOrder->offer_or_promo_id != null)
                    $this->updatePromoOffer($orderType, $checkOffer, $checkPromo);

                ////////////////////////////////////////////////
                // $this->makeEvent($newOrder, $ActiveDelivery);
                ////////////////////////////////////////////////

                DB::commit();
                return $this->sendResponse(['data' => 'add product || pharmacy order   sucessfully', 'Delivery' => DeliveryRecourse::collection($ActiveDelivery)], 200);
            } catch (\Exception $ex) {
                DB::rollback();
                return $ex;
                return $this->sendError(['data' => 'cant add this order please try again'], 404);
            }
        } else {
            try {
                DB::beginTransaction();

                $newOrder = $this->insertOredr($request, $orderType, $checkOffer, $checkPromo);

                $orderDetailsData = json_decode(file_get_contents("php://input"), true);

                foreach ($orderDetailsData as $orderDetail) {
                    $newOrder->orderDetails()->create([
                        'amount'      => $orderDetail['amount'],
                        'price'       => $orderDetail['price'] * $orderDetail['amount'],
                        'product_id'  => $orderDetail['product_id'],
                        'description' => $orderDetail['description'],
                    ]);
                }

                // this is update offer table or promocode 
                if ($newOrder->offer_or_promo_id != null)
                    $this->updatePromoOffer($orderType, $checkOffer, $checkPromo);

                ////////////////////////////////////////////////
                $this->makeEvent($newOrder, $ActiveDelivery);
                ////////////////////////////////////////////////

                DB::commit();
                return $this->sendResponse(['data' => 'add product || pharmacy order   sucessfully', 'Delivery' => DeliveryRecourse::collection($ActiveDelivery)], 200);
            } catch (\Exception $ex) {
                DB::rollback();
                return $ex;
                return $this->sendError(['data' => 'cant add this order please try again'], 404);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }




    protected function checkUserPromo($id)
    {
        $avilablePromo = Promocode::where('user_id', $id)
            ->where('confirm', 1)
            ->where('area_id', auth()->user()->area_id)->first();
        return $avilablePromo;
    }

    protected function checkUserOffer($id)
    {
        $avilableOffer = UserOffer::where('user_id', $id)
            ->where('decrement_trip', '>', 0)
            ->where('end_date', '>', now())->first();
        return $avilableOffer;
    }



    protected function updatePromoOffer($orderType, $checkOffer, $checkPromo)
    {
        if ($orderType == 1) { // this is for decrement offer
            $checkOffer->update([
                'decrement_trip' => $checkOffer->decrement_trip - 1,
            ]);
        } elseif ($orderType == 2) { // this is for confirm the promocode
            $checkPromo->update([
                'confirm'   => 0,
            ]);
        }
    }

    protected function deliveryPriceHOHO($request, $orderType, $checkOffer = null, $checkPromo = null)
    {
        $areaTransFrom = Area::select('trans_price')->where('id', $request->area_id_from)->first();


        if ($orderType == 1) { // if user have an offer 
            if ($checkOffer->Offer->area_id  == auth()->user()->area_id && $checkOffer->Offer->area_id == $request->area_id_from) {
                $deliveryPrice = 0;
                $offerOrPromoId = $checkOffer->id;
                $orderTyoe  = 1;
            } else {
                $deliveryPrice = auth()->user()->area->trans_price + $areaTransFrom['trans_price'];
                $offerOrPromoId = null;
                $orderTyoe  = 0;
            }
        } elseif ($orderType == 2) { // if user have promo 
            if ($checkPromo->area_id  == auth()->user()->area_id && $checkPromo->area_id  == $request->area_id_from) {
                $deliveryPrice = auth()->user()->area->trans_price * $checkPromo->discount / 100;
                $offerOrPromoId = $checkPromo->id;
                $orderTyoe  = 2;
            } else {
                $deliveryPrice = auth()->user()->area->trans_price + $areaTransFrom['trans_price'];
                $offerOrPromoId = null;
                $orderTyoe  = 0;
            }
        } else { // if user not have promo or offer 

            if (auth()->user()->area_id == $request->area_id_from) {
                $deliveryPrice = auth()->user()->area->trans_price;
                $offerOrPromoId = null;
                $orderTyoe  = 0;
            } else {
                $deliveryPrice = auth()->user()->area->trans_price + $areaTransFrom['trans_price'];
                $offerOrPromoId = null;
                $orderTyoe = 0;
            }
        }

        $deliveryPriceData = ['deliveryPrice' => $deliveryPrice, 'offerOrPromoId' => $offerOrPromoId, 'orderTyoe' => $orderTyoe];

        return $deliveryPriceData;
    }




    protected function insertOredr($request, $orderType, $checkOffer = null, $checkPromo = null)
    {
        if ($orderType == 1) { // if user have an offer 
            if ($checkOffer->Offer->area_id  == auth()->user()->area_id || $checkOffer->Offer->area_id == $request->area_id) {
                $deliveryPrice = 0;
                $offerOrPromoId = $checkOffer->id;
                $checkOrderType = 1;
            } else {
                $deliveryPrice = auth()->user()->area->trans_price;
                $offerOrPromoId = null;
                $checkOrderType = 0;
            }
        } elseif ($orderType == 2) { // if user have promo 
            if ($checkPromo->area_id  == auth()->user()->area_id || $checkPromo->area_id  == $request->area_id) {
                $deliveryPrice = auth()->user()->area->trans_price * $checkPromo->discount / 100;
                $offerOrPromoId = $checkPromo->id;
                $checkOrderType = 2;
            } else {
                $deliveryPrice = auth()->user()->area->trans_price;
                $offerOrPromoId = null;
                $checkOrderType = 0;
            }
        } else { // if user not have promo or offer 
            $deliveryPrice = auth()->user()->area->trans_price;
            $offerOrPromoId = null;
            $checkOrderType = 0;
        }
        $newOrder = $this->model->create([
            'client_id'      => auth()->user()->id,
            'delivery_price' => $deliveryPrice,
            'area_id'        => $request->area_id ?? auth()->user()->area_id,
            'type'           => $checkOrderType,
            'offer_or_promo_id' => $offerOrPromoId,
        ]);

        return $newOrder;
    }


    protected function makeEvent($newOrder, $ActiveDelivery)
    {
        $data = [
            'user_id'           =>  auth()->user()->id,
            'firstName'         =>  auth()->user()->name,
            'order_id'          =>  $newOrder->id,
            'active_delivery'   => $ActiveDelivery,
        ];
        event(new DeliveryNotifyEvent($data));
    }

    protected function uploadImage($request)
    {
        $img = \Intervention\Image\Facades\Image::make($request->image)->resize(800, 500);
        // save file as jpg with medium quality
        $img->save(public_path('uploads/orders_images/' . $request->image->hashName()), 70);
    }
}
