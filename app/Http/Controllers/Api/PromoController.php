<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromoResource;
use App\Models\Promocode;
use Illuminate\Http\Request;

class PromoController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promoCode  = Promocode::where('user_id', auth()->user()->id)->where('confirm', 1)->get();
        if ($promoCode->count() > 0)
            return $this->sendResponse(PromoResource::collection($promoCode), 200);
        else
            return $this->sendError("sorry you haven't  any prom ", ['No Data'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $promoCode  = Promocode::where('confirm', 1)->where('serial', $request->promo)->first();
        if ($promoCode  && $promoCode->user_id == auth()->user()->id) {
            return $this->sendResponse(['alert' => 'you have this promo ', 'data' => new PromoResource($promoCode)], 200);
        } elseif ($promoCode && $promoCode->user_id == null) {
            $promoCode->update([
                'user_id'   => auth()->user()->id,
            ]);
            return $this->sendResponse(['alert' => 'congreatulation you win gift from this promo ', 'data' => new PromoResource($promoCode)], 200);
        } else {
            return $this->sendError('promo not valid ', ['No Data'], 200);
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
