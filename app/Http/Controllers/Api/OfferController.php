<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use App\Models\UserOffer;
use Illuminate\Http\Request;

class OfferController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::latest()->get();
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
        $offerCheck = Offer::find($request->offer_id);
        if ($offerCheck) {

            $request["offer_id"] = $offerCheck->id;
            $request["user_id"] = auth()->user()->id;
            $request["decrement_trip"] = $offerCheck->trips_count;
            $request["price"] = $offerCheck->price;
            $request["end_date"] = date('Y-m-d', strtotime(' + ' . $offerCheck->offer_days . ' day'));;
            $request['added_by'] = auth()->user()->id;

            UserOffer::create($request->all());
            return $this->sendResponse('you take this offer sucessfully', 200);
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
}
