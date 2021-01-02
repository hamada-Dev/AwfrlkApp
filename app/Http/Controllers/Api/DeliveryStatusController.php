<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryStatusRecourse;
use App\Models\DeliveryStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DeliveryStatusController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return User::where('delivery_id', auth()->user()->id)->get();
        $deliveryStatus = DeliveryStatus::where('user_id', auth()->user()->id)->get()->last();

        if ($deliveryStatus->count() > 0)
            return $this->sendResponse(new DeliveryStatusRecourse($deliveryStatus), 200);
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
        $request->validate([
            'status'    =>  ['numeric', Rule::in([1, 2]),],
        ]);
        $userDelivery = User::delivery()->where('id', auth()->user()->id)->first();

        if ($request->status != $userDelivery->delivery_status) {
            try {
                DB::beginTransaction();

                $userDelivery->update([
                    'delivery_status'   => $request->status,
                ]);

                $userDelivery->deliveryStatus()->update([]);

                $userDelivery->deliveryStatus()->create([
                    'status'    => $request->status,
                ]);

                DB::commit();
                return $this->sendResponse(['data' => $request->status == 1 ? 'you Active Now ' : 'yoy Not Active'], 200);
            } catch (\Exception $ex) {
                DB::rollback();
                return $this->sendError('There is an errror when change status', ['No Data'], 404);
            }
        } else {
            return $this->sendError('you are in this status', ['No Data'], 404);
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
}
