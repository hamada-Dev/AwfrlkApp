<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\BackEnd\BackEndController;
use App\Http\Controllers\Controller;
use App\Models\UserOffer;
use App\Models\User;
use App\Models\Offer;
use App\Scopes\ConfirmedOffer;
use App\Scopes\NonDeleteIScope;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Null_;

class UserOffersController extends BackEndController
{

    public function __construct(UserOffer $model)
    {
        parent::__construct($model);
    }




    public function index(Request $request)
    {
        //get all data of Model
        $rows = $this->model;
        $rows = $this->filter($rows);

        $rows = $rows->when($request->nonpay, function ($query) use ($request) {
            return $query->withOutGlobalScope(ConfirmedOffer::class)->where('user_id', $request->nonpay)->whereNull('confirm_date');
        })->when($request->offerNotPay , function($qu) {
                return  $qu->withOutGlobalScope(ConfirmedOffer::class)->whereNull('confirm_date');
        })->paginate(5);

        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $rows;

        return view('back-end.' . $this->getClassNameFromModel() . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    } //end of index


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        $append = $this->append();
        $users = User::where("group", "user")->get();
        $offers = Offer::get();

        return view('back-end.' . $this->getClassNameFromModel() . '.create', compact('users', 'offers', 'module_name_singular', 'module_name_plural'))->with($append);
    }

    public function store(Request $request)
    {
        $checkUserNonPay = UserOffer::withoutGlobalScope(ConfirmedOffer::class)->whereNull('confirm_date')->where('user_id', $request->user_id)->get();
        if ($checkUserNonPay->count() > 0) { // check if this user have offer and not paied mony
            session()->flash('error', 'لقد تم الاشتارك في عرض مسبق ولم يتم السداد بعد');
            return redirect()->route('useroffers.index', ['nonpay' =>  $request->user_id]);
        }

        $avilableOffer = UserOffer::where('user_id', $request->user_id)
            ->where('decrement_trip', '>', 0)
            ->where('end_date', '>', now())->get();
        if($avilableOffer->count() > 0){
            session()->flash('error', 'هذا العميل يتمتع بعرض لم ينتهي بعد او يمر عليه الفتره المحدده');
            return redirect()->route('useroffers.index', ['nonpay' =>  $request->user_id]);
        }

        $request->validate([
            'user_id'   =>  ['required', 'numeric', 'exists:users,id'],
            'offer_id'   =>  ['required', 'numeric', 'exists:offers,id'],
        ]);
        $num = Offer::select("trips_count", "offer_days", "price")->where("id", $request->offer_id)->first();
        $request["decrement_trip"] = $num->trips_count;
        $request["price"] = $num->price;
        $request["end_date"] = date('Y-m-d', strtotime(' + ' . $num->offer_days . ' day'));;
        $request['added_by'] = auth()->user()->id;

        $this->model->create($request->all());

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('useroffers.index');
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
        $offers = Offer::where("avilable", "0")->get();

        return view('back-end.' . $this->getClassNameFromModel() . '.edit', compact('users', 'offers', 'row', 'module_name_singular', 'module_name_plural'))->with($append);
    } //end of edit

    public function update(Request $request, $id)
    {

        $request->validate([
            'user_id'   =>  ['required', 'numeric', 'exists:users,id'],
            'offer_id'   =>  ['required', 'numeric', 'exists:offers,id'],
        ]);
        $num = Offer::select("trips_count", "offer_days")->where("id", $request->offer_id)->first();
        $request["decrement_trip"] = $num->trips_count;
        $request["end_date"] = date('Y-m-d', strtotime(' + ' . $num->offer_days . ' day'));
        $userOffer = $this->model->find($id);
        $userOffer->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('useroffers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        // return $request;

        $userOfferDelete = UserOffer::when($request->userOfferNonPay, function($query) use($request){
            return $query->withOutGlobalScope(ConfirmedOffer::class);
        })->findOrFail($id);


        $userOfferDelete->update([
            'deleted_by'    => auth()->user()->id,
            'delete_date'   => now(),
        ]);

        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route($this->getClassNameFromModel() . '.index');
    }
}
