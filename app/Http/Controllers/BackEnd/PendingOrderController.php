<?php

namespace App\Http\Controllers\BackEnd;

use App\Events\AdminForceDeliveryEvent;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendingOrderController extends BackEndController
{

    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return $request->process;

        //get all data of Model

        $rows = $this->model->when($request->orderId, function ($que) use ($request) {
            return $que->where('id', $request->orderId);
        })->with(['orderDetails' => function ($query) {
            return $query->with('product');
        }])->when($request->process, function ($q) use ($request) {
            return $q->whereNull('delivery_id')->where('status', $request->process);
        })->with('user')->latest()->paginate(6);


        // //get all data of Model
        // $rows = $this->model->when($request->orderId, function ($que) use ($request) {
        //     return $que->where('id', $request->orderId);
        // })->with(['orderDetails' => function ($query) {
        //     return $query->with('product');
        // }])->where('delivery_id', null)->with('user')->latest()->paginate(6);

        // return $rows;

        // active delivery 
        $activeDelivery = User::deliveryActive()->get();

        return view('back-end.pendingOrderes.index', compact('activeDelivery', 'rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
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
            'delivery_id'   =>  ['required', 'numeric', 'exists:users,id'],
            'order_id'      =>  ['required', 'numeric', 'exists:orders,id'],
        ]);

        $newOrder    = Order::find($request->order_id);
        $checkActive = User::where('id', $request->delivery_id)->first();

        if ($newOrder->status != 1) {
            if ($checkActive->delivery_status == 1) {

                try {
                    DB::beginTransaction();
                    $newOrder->update([
                        'delivery_id'   =>  $request->delivery_id,
                        'admin_id'      =>  auth()->user()->id,
                    ]);

                    $this->changeDeliveryStatus($request->delivery_id);
                    DB::commit();
                } catch (\Exception $ex) {
                    DB::rollback();
                    return $ex;
                }

                $order_details   =  $newOrder->orderDetails()->get();
                $order_client    =  User::find($newOrder->client_id);
                $order_delivery  =  User::find($newOrder->delivery_id);
                $alert           = 'admin Forcing this delivery to take  this order';

                $this->makeEvent($order_details, $order_delivery, $order_client, $alert);

                session()->flash('success', "تم تكليف الطيار بنجاح ");
                return redirect()->route('pending.index');
            } else {
                session()->flash('error', "هذا الطيار مشغول بتوصيل طلب اخر ");
                return redirect()->route('pending.index');
            }
        } else {
            session()->flash('error', "تم الانتهاء من هذا الطلب");
            return redirect()->route('pending.index');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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


    protected function changeDeliveryStatus($id)
    {
        $user = User::find($id);
        $user->update([
            'delivery_status'   => 0,
        ]);
        $deliveryStatus = $user->deliveryStatus()->orderBy('created_at', 'DESC')->first();

        $deliveryStatus->update([
            'updated_at'    => now(),
        ]);
        $user->deliveryStatus()->create([
            'status'    => 0,
        ]);
    }


    // event for take order 
    protected function makeEvent($myOrder, $deliveryData, $userData, $alert)
    {
        $data = [
            'order_detail'     => $myOrder,
            'delivery_data'    => $deliveryData,
            'user_data'        => $userData,
            'alert'            => $alert,
        ];
        event(new AdminForceDeliveryEvent($data));
    }
}
