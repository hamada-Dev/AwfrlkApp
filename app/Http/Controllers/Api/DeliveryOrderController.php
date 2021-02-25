<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderDeliveryRecourse;
use App\Http\Resources\OrderDetailsRecourse;
use App\Http\Resources\PendingOrderResource;
use App\Models\Advance;
use App\Models\Order;
use App\Models\User;
use Dotenv\Regex\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryOrderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) // this return all delivery order  
    {                                       // if requerst == current return curent order 
        // if request  == shift return order for thsi shift
        if ($request->shift == 1) {
            $deliveryShift = Advance::where('user_id', auth()->user()->id)->get()->last();
            $startShift = $deliveryShift ? $deliveryShift->created_at : auth()->user()->updated_at;

            $delivryOrder =  Order::where('delivery_id', auth()->user()->id)
                ->where('created_at', '>=', $startShift)->latest()->get();
        } else {
            $delivryOrder =  Order::when($request->curent, function ($query) {
                return $query->whereNull('arrival_date');
            })->where('delivery_id', auth()->user()->id)->latest()->get();
        }

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
        $delivryOrder =  Order::whereNull('delivery_id')->with('orderDetails')->with('user')->latest()->get();
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
        $orderDeleted =  Order::where('delivery_id', auth()->user()->id)
            ->whereNull('arrival_date')->whereNotNull('delete_date')->find($id);

        if ($orderDeleted) { // if user want to delete this order by (delete_date  NOT NULL)
            try {
                DB::beginTransaction();
                $orderDeleted->deleted_by    = auth()->user()->id;
                $orderDeleted->save();
                $orderDeleted->orderDetails()->update([
                    'deleted_by'  => auth()->user()->id,
                ]);
                $this->changeDeliveryStatus(auth()->user()->id, 1);
                DB::commit();
                return $this->sendResponse('you deleted this order Successfully ', 200);
            } catch (\Exception $ex) {
                DB::rollback();
                return $this->sendError('there is no order with this id ', 'not find', 200);
                throw $ex;
            }
        }else{
            return $this->sendError('you cant delete this order until user give you permation', 'not find', 200);
        }
    }


    protected function changeDeliveryStatus($id, $status)
    {
        $user = User::find($id);
        $user->update([
            'delivery_status'   => $status,
        ]);
        $deliveryStatus = $user->deliveryStatus()->orderBy('created_at', 'DESC')->first();

        $deliveryStatus->update([
            'updated_at'    => now(),
        ]);
        $user->deliveryStatus()->create([
            'status'    => $status,
        ]);
    }
}
