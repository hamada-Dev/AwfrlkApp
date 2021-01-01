<?php

namespace App\Http\Controllers\Api;

use App\Events\DeliveryNotifyEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryRecourse;
use App\Http\Resources\OrderUserRecourse;
use App\Http\Resources\UserOfferResource;
use App\Models\Area;
use App\Models\Order;
use App\Models\OrderDetail;
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
        // return (json_decode(file_get_contents("php://input"), true));
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
                $areaTransFrom = Area::select('trans_price')->where('id', $request->area_id_from)->first();

                $newOrder = $this->model->create([
                    'client_id'      =>  auth()->user()->id,
                    'area_id'        =>  $request->area_id ?? auth()->user()->area_id,
                    'adress'         =>  $request->adress ?? auth()->user()->adress,
                    'area_id_from'   =>  $request->area_id_from,
                    'adress_from'    =>  $request->adress_from,
                    'delivery_price' =>  auth()->user()->area_id == $request->area_id_from ? auth()->user()->area->trans_price : auth()->user()->area->trans_price + $areaTransFrom->trans_price,
                    'type'           => $orderType,
                ]);

                $newOrder->orderDetails()->create([
                    'product_home' => $request->product_home,
                    'description'  => $request->description,
                ]);

                // this is update offer table or promocode 
                $this->updatePromoOffer($orderType, $checkOffer, $checkPromo);

                DB::commit();
                return $this->sendResponse(['data' => 'add home order   sucessfully', 'Delivery' => DeliveryRecourse::collection($ActiveDelivery)], 200);
            } catch (\Exception $ex) {
                DB::rollback();
                return $this->sendError(['data' => 'cant add this order please try again'], 404);
            }
        } else {
            try {
                DB::beginTransaction();
                $newOrder = $this->model->create([
                    'client_id'      => auth()->user()->id,
                    'delivery_price' => auth()->user()->area->trans_price,
                    'area_id'        => $request->area_id ?? auth()->user()->area_id,
                    'type'           => $orderType,
                ]);

                $orderDetailsData = json_decode(file_get_contents("php://input"), true);

                foreach ($orderDetailsData as $orderDetail) {
                    if ($orderDetail['image'] != null) {
                        $this->uploadImage($orderDetail);
                    }
                    $newOrder->orderDetails()->create([
                        'amount'      => $orderDetail['amount'],
                        'price'       => $orderDetail['price'] * $orderDetail['amount'],
                        'product_id'  => $orderDetail['product_id'],
                        'description' => $orderDetail['description'],
                        'image'       => $orderDetail['image'] == null ? null :  $orderDetail['pharmacyImage']->hashName(),
                    ]);
                }

                // this is update offer table or promocode 
                $this->updatePromoOffer($orderType, $checkOffer, $checkPromo);

                ////////////////////////////////////////////////
                $data = [
                    'user_id'   =>  auth()->user()->id,
                    'firstName' =>  auth()->user()->firstName,
                    'order_id'  =>  $newOrder->id,
                ];
                event(new DeliveryNotifyEvent($data));
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
            ->where('confirm', 1)->first();
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



    protected function uploadImage($request)
    {
        $img = \Intervention\Image\Facades\Image::make($request['pharmacyImage'])->resize(800, 500);
        // save file as jpg with medium quality
        $img->save(public_path('uploads/orders_images/' . $request['pharmacyImage']->hashName()), 70);
    }
}
