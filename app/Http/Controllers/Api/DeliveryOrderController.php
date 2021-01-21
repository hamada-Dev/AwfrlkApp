<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderDeliveryRecourse;
use App\Http\Resources\OrderDetailsRecourse;
use App\Http\Resources\PendingOrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class DeliveryOrderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivryOrder =  Order::where('delivery_id', auth()->user()->id)->get();

        if ($delivryOrder->count() > 0)
            return $this->sendResponse(OrderDeliveryRecourse::collection($delivryOrder), 200);
        else
            return $this->sendError('There is no order for this delivery', ['No Data'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $delivryOrder =  Order::whereNull('delivery_id')->with('orderDetails')->with('user')->get();
        if ($delivryOrder->count() > 0)
            return $this->sendResponse(PendingOrderResource::collection($delivryOrder), 200);
        else
            return $this->sendError('there is no pending order', OrderDeliveryRecourse::collection($delivryOrder), 200);
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
}
