<?php

namespace App\Http\Controllers\Api;

use App\Events\DeliveryEndShopingOrderEvent;
use App\Events\OrderHasBeenAcceptEvent;
use App\Http\Resources\OrderDetailsRecourse;
use App\Http\Resources\UserResource;
use App\Models\DeliveryStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryTakeOrderController extends BaseController
{

    // delivery take this order 
    public function store(Request $request)
    {

        $newOrder = Order::find($request->order_id);

        if ($newOrder) {
            if ($newOrder->delivery_id == null && auth()->user()->delivery_status  == 1) {

                try {
                    DB::beginTransaction();
                    $newOrder->update([
                        'delivery_id'   =>  auth()->user()->id,
                    ]);

                    $this->changeDeliveryStatus(auth()->user()->id);
                    DB::commit();
                } catch (\Exception $ex) {
                    DB::rollback();
                    return $ex;
                }


                $order_details   =  OrderDetailsRecourse::collection($newOrder->orderDetails);
                $order_client    =  new UserResource(User::find($newOrder->client_id));
                $order_delivery  =  new UserResource(User::find($newOrder->delivery_id));

                $this->makeEvent($order_details, $order_delivery);

                return $this->sendResponse(['user_date' => $order_client, 'order_details' => $order_details], 200);
            } else {
                return $this->sendError(' another delivery take it befor you', ['No Data'], 200);
            }
        } else {
            return $this->sendError('There is order not found || has been deleted', ['No Data'], 404);
        }
    }

    // delivery end shopping 
    public function endShoping(Request $request)
    {
        $newOrder = Order::find($request->order_id);
        if ($newOrder) {
            if ($newOrder->delivery_id == auth()->user()->id) {
                if ($newOrder->end_shoping_date == null) {
                    if ($newOrder->orderDetails[0]->product_home == null && $newOrder->orderDetails[0]->product_id == null) { // this pharmacy drive have to enter price 

                        $request->validate([
                            'price'     =>  ['required', 'numeric',],
                        ]);
                        $newOrder->update([
                            "price"             => $request->price,
                            "end_shoping_date"  => now(),
                        ]);
                    } else { // this is a product order or from home to home 
                        $newOrder->update([
                            "end_shoping_date"  => now(),
                        ]);
                    }
                    $order_details   =  OrderDetailsRecourse::collection($newOrder->orderDetails);
                    $order_delivery  =  new UserResource(User::find($newOrder->delivery_id));
                    $order_details_total_price   = $newOrder->OrderPrice;

                    $this->makeEventEnd($order_details, $order_delivery, $order_details_total_price);

                    return $this->sendResponse(['user_date' => $order_delivery, 'order_details' => $order_details], 200);
                } else {
                    return $this->sendError(" you confirm end shoping later", ['No Data'], 200);
                }
            } else {
                return $this->sendError("you don't have this order ", ['No Data'], 404);
            }
        } else {
            return $this->sendError('There is order not found || has been deleted', ['No Data'], 404);
        }
    }

    // event for take order 
    protected function makeEvent($myOrder, $deliveryData)
    {
        $data = [
            'my_order_detail'     => $myOrder,
            'accepted_delivery'   => $deliveryData,
        ];
        event(new OrderHasBeenAcceptEvent($data));
    }

    // event for end shoping 
    protected function makeEventEnd($myOrder, $deliveryData, $order_total_price)
    {
        $data = [
            'my_order_detail'     => $myOrder,
            'accepted_delivery'   => $deliveryData,
            'order_total_price'   => $order_total_price,
        ];
        event(new DeliveryEndShopingOrderEvent($data));
    }


    protected function changeDeliveryStatus($id)
    {
        $user = User::find($id);
        $user->update([
            'delivery_status'   => 0,
        ]);
        $deliveryStatus = $user->deliveryStatus()->orderBy('created_at', 'DESC')->first();

        $deliveryStatus->update([
            'updated_at'    => now(),
        ]);
        $user->deliveryStatus()->create([
            'status'    => 0,
        ]);
    }
}
