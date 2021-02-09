<?php

namespace App\Http\Controllers\Api;


use App\Http\Resources\UserOfferOrderResource;
use App\Http\Resources\UserOfferResource;
use App\Models\UserOffer;
use Illuminate\Http\Request;

class UserOfferController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userOffer = UserOffer::where('user_id', auth()->user()->id)->latest()->get();
        if ($userOffer->count() > 0)
            return $this->sendResponse(UserOfferResource::collection($userOffer), 'user offer data');
        else
            return $this->sendError('no data', 'this user has no offer', 200);
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
        return  $userOffer = UserOffer::where('id', $id)->with(['order' => function ($query) {
            return $query->where('type', 1);
        }])->where('user_id', auth()->user()->id)->latest()->get();

        if ($userOffer->count() > 0)
            return $this->sendResponse(UserOfferOrderResource::collection($userOffer), 'user offer data');
        else
            return $this->sendError('no data', 'this user has no offer', 200);
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
