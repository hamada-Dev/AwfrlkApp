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
        $deliveryStatus = User::find(auth()->user()->id);

        $deliverySTa = $deliveryStatus->delivery_status == 1 ? 'active' : ($deliveryStatus->delivery_status == 0 ? 'busy' : 'Not Active');

        if ($deliveryStatus->count() > 0)
            return $this->sendResponse(['type' => $deliverySTa, 'from' => $deliveryStatus->updated_at->diffForHumans()], 200);
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
        $userDelivery = User::find(auth()->user()->id);

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
                return $this->sendResponse(['data' => $request->status == 1 ? 'you Active Now ' : ($request->status == 0 ? 'you Busy' : 'you Not Active') ], 200);
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
