<?php

namespace App\Http\Controllers\Api;

use App\Events\userFeedbackOrderEvent;
use App\Http\Resources\OrderDetailsRecourse;
use App\Http\Resources\UserResource;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;


class UserOrderFeedbackController extends BaseController
{
    // user make feedback about this order 
    public function userFeedbackOrder(Request $request)
    {
        $newOrder = Order::find($request->order_id);

        if ($newOrder) {
            if ($newOrder->client_id == auth()->user()->id) {
                $newOrder->update([
                    // "feedback"       => $request->feedback,
                    "feedback_date"  => now(),
                ]);

                
                $order_details   =  OrderDetailsRecourse::collection($newOrder->orderDetails);
                $order_delivery  =  new UserResource(User::find($newOrder->delivery_id));
                $order_client    =  new UserResource(User::find($newOrder->client_id));
                $order_details_total_price   = $newOrder->OrderPrice;

                $this->makeEvent($order_details, $order_delivery, $order_client, $order_details_total_price);


                
                return $this->sendResponse('order has been ended .... thanks now you are active ', 200);
            } else {
                return $this->sendError("you don't have this order ", ['No Data'], 404);
            }
        } else {
            return $this->sendError('There is order not found || has been deleted', ['No Data'], 404);
        }
    }



    // event for take order 
    protected function makeEvent($order_details, $order_delivery, $order_client, $order_details_total_price)
    {
        $data = [
            'order_detail'     => $order_details,
            'delivery_data'    => $order_delivery,
            'user_data'        => $order_client,
            'order_details_total_price'  => $order_details_total_price,
        ];
        event(new userFeedbackOrderEvent($data));
    }
}
