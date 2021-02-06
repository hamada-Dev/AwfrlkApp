<?php

namespace App\Http\Controllers\Api;

use App\Events\DeliveryTakeOfferEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserOfferResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserOffer;
use App\Scopes\ConfirmedOffer;
use Illuminate\Http\Request;

class DeliveryTakeOfferController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $avilableOffer = UserOffer::where('delivery_id', auth()->user()->id)->whereNull('confirm_date')->get();
        // ->withoutGlobalScope(ConfirmedOffer::class)
        if ($avilableOffer->count() > 0)
            return $this->sendResponse('you have offer but not collect money', ['userOffer' => UserOfferResource::collection($avilableOffer)], 200);
        else
            return $this->sendResponse('u have no offer to earn money',  ['userOffer' => UserOfferResource::collection($avilableOffer)], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $findUserOffer = UserOffer::where('id', $request->id)
                                    ->whereNull('delivery_id')
                                    ->withoutGlobalScope(ConfirmedOffer::class)->first();


        if (!empty($findUserOffer)) {

            // get all notification data
            $offerData    = new UserOfferResource($findUserOffer);
            $userInfo     = new UserResource(User::find($findUserOffer->user_id));
            $deliveryInfo = new UserResource(User::find(auth()->user()->id));

            $data = ['offerData' => $offerData, 'userInfo' => $userInfo, 'DeliveryInfo' => $deliveryInfo];

            // update offer tabel with delivery_id
            $findUserOffer->update([
                'delivery_id'   => auth()->user()->id
            ]);

            ////////////////////////////////////////////////
            $this->makeEvent($offerData, $userInfo, $deliveryInfo);
            ////////////////////////////////////////////////


            return $this->sendResponse('you have offer but not collect money', ['userOffer' => $data], 200);
        } else {
            return $this->sendResponse('this is user offer not found ', ['No Data'], 200);
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
        $CollectOffer = UserOffer::where('delivery_id', auth()->user()->id)->get();
        // ->withoutGlobalScope(ConfirmedOffer::class)
        if ($CollectOffer->count() > 0)
            return $this->sendResponse('offer you earn money ', ['userOffer' => UserOfferResource::collection($CollectOffer)], 200);
        else
            return $this->sendResponse('no offer you earn money ',  ['userOffer' => UserOfferResource::collection($CollectOffer)], 200);
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


    
    protected function makeEvent($offerData, $userInfo, $deliveryInfo)
    {
        $data = [
            'offer_data'        => $offerData,
            'user_data'         =>  $userInfo,
            'delivery_data'     =>  $deliveryInfo,
        ];
        event(new DeliveryTakeOfferEvent($data));
    }

}
