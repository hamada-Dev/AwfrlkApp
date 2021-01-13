<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\BackEnd\BackEndController;
use App\Models\Order;
use App\Models\User;
use App\Models\Area;
use App\Models\Promocode;
use App\Models\UserOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OredersController extends BackEndController
{

    public function __construct(Order $model)
    {
        parent::__construct($model);
    }




    public function index(Request $request)
    {
        // return $request;
        //get all data of Model
        $rows = $this->model;
        $rows = $this->filter($rows);
        $rows = $rows->when($request->delivery_id, function ($query) use ($request) {
            $query->where('delivery_id', $request->delivery_id)->where('created_at', '>', $request->created_at);
        })->latest()->paginate(4);

        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $rows;
        $users = User::all();
        return view('back-end.' . $this->getClassNameFromModel() . '.index', compact("users", 'rows', 'module_name_singular', 'module_name_plural'));
    } //end of index

    public function create(Request $request)
    {
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        $append = $this->append();
        $users = User::where("group", "user")->get();
        $delivers = User::deliveryActive()->get();
        $areas = Area::all();
        return view('back-end.' . $this->getClassNameFromModel() . '.create', compact('users', 'delivers', 'areas', 'module_name_singular', 'module_name_plural'))->with($append);
    } //en
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'feedback'    =>  ['required', 'string', 'max:250', 'min:5'],
            'client_id'   =>  ['required', 'numeric', 'exists:users,id'],
            'delivery_id' =>  ['required', 'numeric', 'exists:users,id'],
            'order_type'  =>  ['required', 'numeric', Rule::in([0, 1, 2])],
        ]);

        $ActiveDelivery = User::deliveryActive()->find($request->delivery_id);
        if (empty($ActiveDelivery)) {
            session()->flash('error', 'هذا الطيار مشغول الان برجاء اختيار طيار اخر ');
            return redirect()->back()->with(['delivery_id' => $request->delivery_id, 'client_id' => $request->client_id, 'feedback' => $request->feedback,]);
        }


        $this->changeDeliveryStatus($ActiveDelivery);


        return redirect()->route('orderdetails.create', ['orderType' => $request->order_type])->with(['delivery_id' => $request->delivery_id, 'client_id' => $request->client_id, 'feedback' => $request->feedback,]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        $append = $this->append();
        $row = $this->model->findOrFail($id);
        $users = User::where("group", "user")->get();
        $delivers = User::deliveryActive()->get();
        $areas = Area::all();
        return view('back-end.' . $this->getClassNameFromModel() . '.edit', compact('users', 'delivers', 'areas', 'row', 'module_name_singular', 'module_name_plural'))->with($append);
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([

            'status' => ['numeric', Rule::in([0, 1])],
            'end_shoping_date' => [],
            'arrival_date'   =>  [],
            'feedback'   =>  ['max:250', 'min:5'],
            'client_id' => ['required', 'numeric', 'exists:users,id'],
            'area_id' => ['required', 'numeric', 'exists:areas,id'],

        ]);
        // delivery_price is limit from area id
        $request["delivery_price"] = Area::select("trans_price")->where("id", $request->area_id)->first()->trans_price;
        if ($request->feedback != null) {
            $request["feedback_date"] = now();
        }
        $request = $request->except('order_type');

        $order->update($request);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        // return 'uunder update plz be patient';
        $order = Order::findOrFail($id);
        if ($order->status == 0) {
            if ($order->type == 1) { //this is offer
                $useroffer = UserOffer::find($order->offer_or_promo_id);
                $useroffer->decrement_trip += 1;
                $useroffer->save();
            } elseif ($order->type == 2) { // this is promo 
                $userpromo = Promocode::find($order->offer_or_promo_id);
                $userpromo->confirm = 0;
                $userpromo->save();
            }
            $order->deleted_by  = auth()->user()->id;
            $order->delete_date = now();
            $order->save();
            session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route($this->getClassNameFromModel() . '.index');
        } else {
            session()->flash('error', 'غير قادر علي الحذف حيث ان اعميل استلم الطلب');
            return redirect()->route($this->getClassNameFromModel() . '.index');
        }
    }






    protected function changeDeliveryStatus($ActiveDelivery)
    {
        $ActiveDelivery->update([
            'delivery_status'   => 0,
        ]);
        $deliveryStatus = $ActiveDelivery->deliveryStatus()->orderBy('created_at', 'DESC')->first();

        $deliveryStatus->update([
            'updated_at'    => now(),
        ]);
        $ActiveDelivery->deliveryStatus()->create([
            'status'    => 0,
        ]);
    }
}
