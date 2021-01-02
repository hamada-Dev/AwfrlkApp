<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryArrivalOrderController extends BaseController
{
    // delivery make arrivel date for this order 
    public function arrivalDateDelivery(Request $request)
    {
        $newOrder = Order::find($request->order_id);

        if ($newOrder) {
            if ($newOrder->delivery_id == auth()->user()->id) {
                if ($newOrder->end_shoping_date != null) {
                    // if ($newOrder->status == 1) {
                    try {
                        DB::beginTransaction();
                        $newOrder->update([
                            "status"        => 1,
                            "arrival_date"  => now(),
                        ]);
                        $this->changeDeliveryStatus($newOrder->delivery_id);
                        DB::commit();
                    } catch (\Exception $ex) {
                        DB::rollback();
                        return $ex;
                    }
                    return $this->sendResponse('thanks for your feedback ', 200);
                    // } else {
                    //     return $this->sendError("this order has been ended later", 200);
                    // }
                } else {
                    return $this->sendError("you have to make end_shoping_date firstly", ['No Data'], 200);
                }
            } else {
                return $this->sendError("you don't have this order ", ['No Data'], 404);
            }
        } else {
            return $this->sendError('There is order not found || has been deleted', ['No Data'], 404);
        }
    }


    protected function changeDeliveryStatus($id)
    {
        $user = User::find($id);
        $user->update([
            'delivery_status'   => 1,
        ]);
        $deliveryStatus = $user->deliveryStatus()->orderBy('created_at', 'DESC')->first();

        $deliveryStatus->update([
            'updated_at'    => now(),
        ]);
        $user->deliveryStatus()->create([
            'status'    => 1,
        ]);
    }
}
