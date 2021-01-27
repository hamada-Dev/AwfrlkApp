<?php

namespace App\Http\Controllers\Api;

use App\Events\DeliveryNotyOfferEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use App\Http\Resources\UserOfferResource;
use App\Http\Resources\UserResource;
use App\Models\Offer;
use App\Models\User;
use App\Models\UserOffer;
use App\Scopes\ConfirmedOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::where('avilable', 1)->latest()->get();
        if ($offers->count() > 0)
            return $this->sendResponse(OfferResource::collection($offers), 200);
        else
            return $this->sendError('theres No Offer Yet');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check for this offer is find or not 
        $offerCheck = Offer::find($request->offer_id);

        $checkAvilUsrOffer =  $this->checkAvilableOffer(auth()->user()->id);
        if ($checkAvilUsrOffer['haveOffer'] == 1)
            return $this->sendResponse($checkAvilUsrOffer['oldOffer'], $checkAvilUsrOffer['message'], 500);

        if ($offerCheck) {
            try {
                DB::beginTransaction();
                $request["offer_id"] = $offerCheck->id;
                $request["user_id"] = auth()->user()->id;
                $request["decrement_trip"] = $offerCheck->trips_count;
                $request["price"] = $offerCheck->price;
                $request["end_date"] = date('Y-m-d', strtotime(' + ' . $offerCheck->offer_days . ' day'));
                // $request['added_by'] = auth()->user()->id;

                $userOffer = UserOffer::create($request->all());

                // get all notification data
                $offerData   = new UserOfferResource($userOffer);
                $ActiveDelivery = UserResource::collection(User::deliveryActive()->get());
                $userInfo = new UserResource(User::find(auth()->user()->id));
                // return $data = ['offerData' => $userOffer, 'userInfo' => $userInfo, 'ActiveDelivery' => $ActiveDelivery];

                ////////////////////////////////////////////////
                 $this->makeEvent($offerData, $userInfo, $ActiveDelivery);
                ////////////////////////////////////////////////

                DB::commit();
                return $this->sendResponse('you take this offer sucessfully', 200);
            } catch (\Exception $ex) {
                DB::rollback();
                return $this->sendError('This is an error plz try again', ['No Data'], 404);
            }
        } else {
            return $this->sendError('This Offer Not Find', ['No Data'], 404);
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

        $offers = Offer::where('area_id', $id)->where('avilable', 1)->latest()->get();
        if ($offers->count() > 0)
            return $this->sendResponse(OfferResource::collection($offers), 200);
        else
            return $this->sendError('theres No Offer Yet');

        // return OfferResource::collection(Offer::whereHas(['user', function ($q) {
        //     return $q->select('offer_id', 'user_id', 'decrement_trip');
        // }])->get());
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
    // to get all offer that not finish yet 
    // SELECT * FROM `user_offers` where decrement_trip > 0 && end_date > now()
    protected function checkAvilableOffer($id)
    {
        $avilableOffer = UserOffer::where('user_id', $id)
            ->where('decrement_trip', '>', 0)
            ->where('end_date', '>', now())->get();

        if ($avilableOffer->count() > 0)
            return $checkResponse = ['haveOffer' => 1, 'oldOffer' => UserOfferResource::collection($avilableOffer), 'message' => 'you cant subscribe for any offer until end this'];


        $avilableOffer = UserOffer::where('user_id', $id)
            ->where('decrement_trip', '>', 0)
            ->where('end_date', '>', now())->withoutGlobalScope(ConfirmedOffer::class)->get();

        if ($avilableOffer->count() > 0)
            return $checkResponse = ['haveOffer' => 1, 'oldOffer' => UserOfferResource::collection($avilableOffer), 'message' => 'you subscribe for offer but not pay money'];

        return $checkResponse = ['haveOffer' => 0, 'message' => 'youcan subscribe for this offer'];
    }


    protected function makeEvent($offerData, $userInfo, $ActiveDelivery)
    {
        $data = [
            'offer_data'        => $offerData,
            'user_data'         =>  $userInfo,
            'active_delivery'   =>  $ActiveDelivery,
        ];
        event(new DeliveryNotyOfferEvent($data));
    }
}
