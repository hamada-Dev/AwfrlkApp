<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderUserRecourse;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends BaseController
{

    public $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userOrder = OrderUserRecourse::collection($this->model->where('client_id', auth()->user()->id)->get());
        if (!empty($userOrder))
            return $this->sendResponse($userOrder, 'orderdata');
        else
            return $this->sendError('300', 'there is no order for this user');
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
            'area_id'   =>  ['required', 'numeric', 'exists:areas,id'],
        ]);
        return $request;

        $this->model->create($request);
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
