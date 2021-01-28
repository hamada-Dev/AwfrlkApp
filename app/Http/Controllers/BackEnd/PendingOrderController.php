<?php

namespace App\Http\Controllers\BackEnd;

use App\Events\AdminForceDeliveryEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderDetailsRecourse;
use App\Http\Resources\UserResource;
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
        })->when($request->process, function ($qu) use ($request) {
            return $qu->whereNull('delivery_id')->where('status', 0);
        })->when($request->delivery, function ($q) use ($request) {
            return $q->whereNotNull('delivery_id')->where('status', 0)->whereNull('end_shoping_date');
        })->when($request->road, function ($quer) use ($request) {
            return $quer->whereNotNull('delivery_id')->where('status', 0)->whereNotNull('end_shoping_date');
        })->with(['orderDetails' => function ($query) {
            return $query->with('product');
        }])->with('user')->latest()->paginate(PAG_COUNT);


        // active delivery 
        $activeDelivery = User::when($request->process, function ($query) use ($request) {
            return $query->deliveryActive();
        })->when($request->delivery, function ($quer) use ($request) {
            return $quer->delivery()->where('delivery_status', 0);
        })->when($request->road, function ($que) use ($request) {
            return $que->delivery()->where('delivery_status', 0);
        })
        ->get();

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
        $checkActive = User::find($request->delivery_id);

        if ($newOrder->status != 1) {
            if ($checkActive->delivery_status == 1) {
                try {
                    DB::beginTransaction();
                    $newOrder->update([
                        'delivery_id'   =>  $request->delivery_id,
                        'admin_id'      =>  auth()->user()->id,
                    ]);

                    $this->changeDeliveryStatus($request->delivery_id);

                    $order_details   =  OrderDetailsRecourse::collection($newOrder->orderDetails()->get());
                    $order_client    =  new UserResource(User::find($newOrder->client_id));
                    $order_delivery  =  new UserResource(User::find($newOrder->delivery_id));
                    $alert           = 'admin Forcing this delivery to take  this order';

                    $this->makeEvent($order_details, $order_delivery, $order_client, $alert);

                    DB::commit();
                    session()->flash('success', "تم تكليف الطيار بنجاح ");
                    return redirect()->route('pending.index');
                } catch (\Exception $ex) {
                    DB::rollback();
                    return $ex;
                }
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
    public function destroy($id, Request $request)
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
