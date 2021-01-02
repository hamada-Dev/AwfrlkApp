<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
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
                    "feedback"       => $request->feedback,
                    "feedback_date"  => now(),
                ]);
                return $this->sendResponse('order has been ended .... thanks now you are active ', 200);
            } else {
                return $this->sendError("you don't have this order ", ['No Data'], 404);
            }
        } else {
            return $this->sendError('There is order not found || has been deleted', ['No Data'], 404);
        }
    }
}
