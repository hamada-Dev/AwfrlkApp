<?php

namespace App\Http\Controllers\Api;

use App\Events\DeliveryNotifyEvent;
use App\Http\Resources\DeliveryRecourse;
use App\Http\Resources\OrderDetailsRecourse;
use App\Http\Resources\OrderUserRecourse;
use App\Http\Resources\UserResource;
use App\Models\Area;
use App\Models\Order;
use App\Models\User;
use App\Models\Promocode;
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
    public function index(Request $request)
    {
        $userOrder = $this->model->where('client_id', auth()->user()->id)
            ->when($request->curent, function ($query) {
                return $query->whereNull('arrival_date');
            })->when(!$request->curent, function ($quer) {
                return $quer->whereNotNull('arrival_date');
            })->latest()->get();

        $userOrder = OrderUserRecourse::collection($userOrder);
        if (!empty($userOrder))
            return $this->sendResponse($userOrder, 'you have orders to show ', 200);
        else
            return $this->sendResponse($userOrder, 'there is no order ', 200);
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
        $ActiveDelivery = UserResource::collection(User::deliveryActive()->where('area_id', $request->area_id)->get());

        $user_id =  auth()->user()->id;

        // check if user has promocode or not 
        $checkPromo = $this->checkUserPromo($user_id, $request);
        //  check if user has offer or not 
        $checkOffer = $this->checkUserOffer($user_id, $request);

        // this is for col type in order 
        $orderType = 0;

        if (!empty($checkPromo)) {
            $orderType = 2;
        } elseif (!empty($checkOffer)) {
            $orderType = 1;
        }

        // this is for return 
        // this is for return 

        if ($request->adress_from) {
            $request->validate([
                'area_id_from'   =>  ['required', 'numeric', 'exists:areas,id'],
                'area_id'        =>  ['required', 'numeric', 'exists:areas,id'],
                'adress'         =>  ['required', 'string', 'max:254'],
                'product_home'   =>  ['required', 'string', 'max:254'],
                'adress_from'    =>  ['required', 'string', 'max:222'],
                'note'           =>  ['nullable', 'string', 'max:200'],
                'guest_phone'    =>  ['nullable', 'numeric', 'regex:/(01)[0-9]{9}/'],
                'guest_phone'    =>  ['nullable', 'numeric', 'regex:/(01)[0-9]{9}/'],
            ]);

            try {
                DB::beginTransaction();
                // start this is for Know how much delivery price /////////
                if ($request->hamada)
                    return $this->deliveryPriceHOHO($request, $orderType, $checkOffer, $checkPromo);
                // end this is for Know how much delivery price //////////

                $deliveyPrice = $this->deliveryPriceHOHO($request, $orderType, $checkOffer, $checkPromo);

                $newOrder = $this->model->create([
                    'client_id'      =>  $user_id,
                    'area_id'        =>  $request->area_id ?? auth()->user()->area_id,
                    'adress'         =>  $request->adress ?? auth()->user()->adress,
                    'area_id_from'   =>  $request->area_id_from,
                    'adress_from'    =>  $request->adress_from,
                    'delivery_price' =>  $deliveyPrice['deliveryPrice'],
                    'offer_or_promo_id' =>  $deliveyPrice['offerOrPromoId'],
                    'type'           => $deliveyPrice['orderTyoe'],
                    'note'           => $request->note,
                    'host_phone'     => $request->host_phone,
                    'guest_phone'    => $request->guest_phone,
                ]);

                $newOrder->orderDetails()->create([
                    'product_home' => $request->product_home,
                    'description'  => $request->description,
                ]);

                ////////////////////////////////////////////////
                $this->makeEvent($newOrder, $ActiveDelivery);
                ////////////////////////////////////////////////

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
        } elseif ($request->pharmacy == 1) {
            $request->validate([
                'area_id'        =>  ['required', 'numeric', 'exists:areas,id'],
                'adress'         =>  ['required', 'string', 'max:254'],
                'image'          =>  ['Nullable', 'image',],
                'description'    =>  ['Nullable', 'string', 'max:222'],
            ]);

            try {
                DB::beginTransaction();

                // start this is for Know how much delivery price /////////
                if ($request->hamada)
                    return $this->insertOredr($request, $orderType, $checkOffer, $checkPromo);
                // end this is for Know how much delivery price //////////
                $newOrder = $this->insertOredr($request, $orderType, $checkOffer, $checkPromo);
                if ($request->image) {
                    $this->uploadImage($request);
                }
                $newOrder->orderDetails()->create([
                    'image'       => $request->image ? $request->image->hashName() : null,
                    'description' => $request->description,
                ]);

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
        } else {
            $request->validate([
                'area_id'         =>  ['required', 'numeric', 'exists:areas,id'],
                'adress'          =>  ['required', 'string', 'max:254'],
                // '*.product_id'    =>  ['required', 'numeric','exists:products,id'],
                // '*.description'   =>  ['Nullable', 'string', 'max:222'],
            ]);
            // return $request['adress'];
            try {
                DB::beginTransaction();
                // start this is for Know how much delivery price /////////
                if ($request->hamada)
                    return $this->insertOredr($request, $orderType, $checkOffer, $checkPromo);
                // end this is for Know how much delivery price //////////
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
                return $this->sendResponse(['data' => 'add product order   sucessfully', 'Delivery' => DeliveryRecourse::collection($ActiveDelivery)], 200);
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

        $orderDeleted =  Order::where('client_id', auth()->user()->id)
            ->whereNull('delivery_id')->find($id);

        $orderCancel  =  Order::where('client_id', auth()->user()->id)
            ->whereNull('arrival_date')->whereNotNull('delivery_id')->find($id);


        if ($orderDeleted) {  // this is order has no delivery take it so user can deleted it directly
            $orderDeleted->deleted_by    = auth()->user()->id;
            $orderDeleted->delete_date   =  now();
            $orderDeleted->save();
            $orderDeleted->orderDetails()->update([
                'deleted_by'  => auth()->user()->id,
                'delete_date'  => now(),
            ]);
            return $this->sendResponse('you deleted this order Successfully because no delivery take it', 200);
        } elseif ($orderCancel) {  // this is order will deleted when user confirmed
            $orderCancel->delete_date   =  now();
            $orderCancel->save();
            $orderCancel->orderDetails()->update([
                'delete_date'  => now(),
            ]);
            return $this->sendResponse('this order will deleted when delivery confirmed ', 200);
        } else {
            return $this->sendError('you cant delete this order after take ', 'not find', 200);
        }
    }



    protected function checkUserPromo($id, $request)
    {
        $avilablePromo = Promocode::where('user_id', $id)
            ->where('confirm', 1)
            ->where('area_id', $request->area_id)
            ->where('end_date', '>', now())->first();
        return $avilablePromo;
    }

    protected function checkUserOffer($id, $request)
    {
        $avilableOffer = UserOffer::where('user_id', $id)
            ->where('decrement_trip', '>', 0)
            ->where('end_date', '>', now())
            ->whereHas('offer', function ($query) use ($request) {
                return $query->where('area_id', $request->area_id);
            })
            ->first();

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
        $areaTransFrom = Area::find($request->area_id_from);
        $area_trans    = Area::find($request->area_id);


        if ($orderType == 1) { // if user have an offer 
            if ($checkOffer->Offer->area_id  == $request->area_id && $checkOffer->Offer->area_id == $request->area_id_from) {
                $deliveryPrice = 0;
                $offerOrPromoId = $checkOffer->id;
                $orderTyoe  = 1;
            } else {
                $deliveryPrice = $area_trans->trans_price + $areaTransFrom->trans_price;
                $offerOrPromoId = null;
                $orderTyoe  = 0;
            }
        } elseif ($orderType == 2) { // if user have promo 
            if ($checkPromo->area_id  == $request->area_id && $checkPromo->area_id  == $request->area_id_from) {
                $deliveryPrice = $area_trans->trans_price * $checkPromo->discount / 100;
                $offerOrPromoId = $checkPromo->id;
                $orderTyoe  = 2;
            } else {
                $deliveryPrice = $area_trans->trans_price + $areaTransFrom->trans_price;
                $offerOrPromoId = null;
                $orderTyoe  = 0;
            }
        } else { // if user not have promo or offer 

            if ($request->area_id == $request->area_id_from) {
                $deliveryPrice = $area_trans->trans_price;
                $offerOrPromoId = null;
                $orderTyoe  = 0;
            } else {
                $deliveryPrice = $area_trans->trans_price + $areaTransFrom->trans_price;
                $offerOrPromoId = null;
                $orderTyoe = 0;
            }
        }
        // start this is for Know how much delivery price /////////
        if ($request->hamada)
            return $data = ['delivery_price' => $deliveryPrice, 'order_type' => $orderTyoe == 0 ? 'PAID' : ($orderTyoe == 1 ? 'OFFER' : 'PROMOCODE')];
        // end this is for Know how much delivery price //////////
        $deliveryPriceData = ['deliveryPrice' => $deliveryPrice, 'offerOrPromoId' => $offerOrPromoId, 'orderTyoe' => $orderTyoe];

        return $deliveryPriceData;
    }




    protected function insertOredr($request, $orderType, $checkOffer = null, $checkPromo = null)
    {
        $area_trans = Area::find($request->area_id);
        if ($orderType == 1) { // if user have an offer 
            if ($checkOffer->Offer->area_id == $request->area_id) {
                $deliveryPrice  = 0;
                $offerOrPromoId = $checkOffer->id;
                $checkOrderType = 1;
            } else {
                $deliveryPrice  = $area_trans->trans_price;
                $offerOrPromoId = null;
                $checkOrderType = 0;
            }
        } elseif ($orderType == 2) { // if user have promo 
            if ($checkPromo->area_id  == $request->area_id) {
                $deliveryPrice  = $area_trans->trans_price  - ($area_trans->trans_price * $checkPromo->discount / 100);
                $offerOrPromoId = $checkPromo->id;
                $checkOrderType = 2;
            } else {
                $deliveryPrice  = $area_trans->trans_price;
                $offerOrPromoId = null;
                $checkOrderType = 0;
            }
        } else { // if user not have promo or offer 
            $deliveryPrice  = $area_trans->trans_price;
            $offerOrPromoId = null;
            $checkOrderType = 0;
        }
        // start this is for Know how much delivery price /////////
        if ($request->hamada)
            return $data = ['delivery_price' => $deliveryPrice, 'order_type' => $checkOrderType == 0 ? 'PAID' : ($checkOrderType == 1 ? 'OFFER' : 'PROMOCODE')];
        // end this is for Know how much delivery price //////////

        $newOrder = $this->model->create([
            'client_id'      => auth()->user()->id,
            'delivery_price' => $deliveryPrice,
            'area_id'        => $request->area_id ?? auth()->user()->area_id,
            'adress'         =>  $request->adress ?? auth()->user()->adress,
            'type'           => $checkOrderType,
            'offer_or_promo_id' => $offerOrPromoId,
            'note'           => $request->note,
        ]);

        return $newOrder;
    }

    protected function makeEvent($newOrder, $ActiveDelivery)
    {
        $data = [
            'order_id'          => $newOrder->id,
            'user_Order'        => new UserResource(User::find(auth()->user()->id)),
            'order_Data'        =>  OrderDetailsRecourse::collection($newOrder->orderDetails),
            'active_Delivery'   => $ActiveDelivery,
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
