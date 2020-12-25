<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\BackEnd\BackEndController;
use App\Http\Controllers\Controller;
use App\Models\UserOffer;
use App\Models\User;
use App\Models\Offer;
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

        $rows = $rows->whereHas('user')->whereHas("offer")->paginate(5);

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
    public function create()
    {
        $module_name_plural=$this->getClassNameFromModel();
        $module_name_singular=$this->getSingularModelName();
        $append =$this->append();
        $users=User::where("group","user")->get();
        $offers=Offer::get();

        return view('back-end.'.$this->getClassNameFromModel().'.create', compact('users','offers','module_name_singular', 'module_name_plural'))->with($append);
    } 

    public function store(Request $request)
    {

        $request->validate([
            'user_id'   =>  ['required', 'numeric', 'exists:users,id'],
            'offer_id'   =>  ['required', 'numeric', 'exists:offers,id'],
        ]);
        $num=Offer::select("trips_count","offer_days", "price")->where("id",$request->offer_id)->first();
        $request["decrement_trip"]=$num->trips_count;
        $request["price"]=$num->price;
        $request["end_date"]= date('Y-m-d', strtotime(' + '. $num->offer_days . ' day'));;
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
        $module_name_plural=$this->getClassNameFromModel();
        $module_name_singular=$this->getSingularModelName();
        $append =$this->append();
        $row=$this->model->findOrFail($id);
        $users=User::where("group","user")->get();
        $offers=Offer::where("avilable","0")->get();

        return view('back-end.'.$this->getClassNameFromModel().'.edit', compact('users','offers','row', 'module_name_singular', 'module_name_plural'))->with($append);
    } //end of edit

    public function update(Request $request,$id)
    {
        
        $request->validate([
            'user_id'   =>  ['required', 'numeric', 'exists:users,id'],
            'offer_id'   =>  ['required', 'numeric', 'exists:offers,id'],
        ]);
        $num=Offer::select("trips_count","offer_days")->where("id",$request->offer_id)->first();
        $request["decrement_trip"]=$num->trips_count;
        $request["end_date"]= date('Y-m-d', strtotime(' + '. $num->offer_days . ' day'));
        $userOffer=$this->model->find($id);
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
    public function destroy($id)
    {
        $product = UserOffer::findOrFail($id);
     
        $product->update([
            'deleted_by'    => auth()->user()->id,
            'delete_date'   => now(),
        ]);
        // $product->delete();

        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route($this->getClassNameFromModel() . '.index');
    }
 
}
