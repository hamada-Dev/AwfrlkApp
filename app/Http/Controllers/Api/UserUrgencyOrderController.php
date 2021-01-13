<?php

namespace App\Http\Controllers\Api;

use App\Events\UserUrgencyOrderEvent;
use App\Http\Resources\OrderDetailsRecourse;
use App\Http\Resources\UserResource;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserUrgencyOrderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newOrder = Order::find($request->order_id);

        if ($newOrder) {
            if ($newOrder->client_id == auth()->user()->id) {
                if ($newOrder->status == 0) { 

                    if($newOrder->delivery_id == null){
                        $order_delivery  =  UserResource::collection(User::DeliveryActive()->get());
                        $message         = 'you have to send this order for all delivery returned ';
                    }else{
                        $order_delivery  =  new UserResource(User::find($newOrder->delivery_id));
                        $message         = 'you have to send this order to this delivery ';
                    }

                    $newOrder->orderUrgency()->create();

                    $order_details   =  OrderDetailsRecourse::collection($newOrder->orderDetails);
                    $order_client    =  new UserResource(User::find($newOrder->client_id));
                    $order_id        =  $newOrder->id;

                    $this->makeEvent($order_details, $order_delivery, $order_client, $message, $order_id);

                    return $this->sendResponse(['user_date' => $order_client, 'order_details' => $order_details], 200);
                } else {
                    return $this->sendError('this is order is finished any problem call admin', ['No Data'], 200);
                }
            } else {
                return $this->sendError(' this is not your order', ['No Data'], 200);
            }
        } else {
            return $this->sendError('There is order not found || has been deleted', ['No Data'], 404);
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


    protected function makeEvent($order_details, $order_delivery, $order_client, $message, $order_id)
    {
        $data = [
            'order_details'     => $order_details,
            'client_order'      => $order_client,
            'delivery_order'    => $order_delivery,
            'message'           => $message,
            'order_id'          => $order_id,
        ];
        event(new UserUrgencyOrderEvent($data));
    }
}
