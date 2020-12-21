<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\BackEnd\BackEndController;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Null_;

class OredersController extends BackEndController
{

    public function __construct(Order $model)
    {
        parent::__construct($model);
    }




    public function index(Request $request)
    {
        //get all data of Model
        $rows = $this->model;
        $rows = $this->filter($rows);
        $rows = $rows->paginate(4);
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $rows;
        $users=User::all();
        return view('back-end.' . $this->getClassNameFromModel() . '.index', compact("users",'rows', 'module_name_singular', 'module_name_plural'));
    } //end of index

    public function create()
    {
        $module_name_plural=$this->getClassNameFromModel();
        $module_name_singular=$this->getSingularModelName();
        $append =$this->append();
        $users=User::where("group","user")->get();
        $delivers=User::where("group","delivery")->get();
        $areas=Area::all();       
         return view('back-end.'.$this->getClassNameFromModel().'.create', compact('users','delivers','areas','module_name_singular', 'module_name_plural'))->with($append);
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

            'status' => ['numeric', Rule::in([0, 1])],
            'end_shoping_date' => [],
            'arrival_date'   =>  [],
            'feedback'   =>  ['required','max:250','min:5'],
            'delivery_id' =>[],
            'client_id' =>['required', 'numeric','exists:users,id'],
            'area_id' =>['required', 'numeric','exists:areas,id'],

        ]);
        // delivery_price is limit from area id
        $request["delivery_price"]=Area::select("trans_price")->where("id",$request->area_id)->first()->trans_price;
        if($request->feedback !=null){
            $request["feedback_date"]=now();
       }
        $this->model->create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('orders.index');
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
        $delivers=User::where("group","delivery")->get();
        $areas=Area::all();  
                return view('back-end.'.$this->getClassNameFromModel().'.edit', compact('users','delivers','areas','row', 'module_name_singular', 'module_name_plural'))->with($append);
    }
    public function update(Request $request, Order $order)
    {
        $request->validate([

            'status' => ['numeric', Rule::in([0, 1])],
            'end_shoping_date' => [],
            'arrival_date'   =>  [],
            'feedback'   =>  ['max:250','min:5'],
            'delivery_id' =>[],
            'client_id' =>['required', 'numeric','exists:users,id'],
            'area_id' =>['required', 'numeric','exists:areas,id'],

        ]);
        // delivery_price is limit from area id
            $request["delivery_price"]=Area::select("trans_price")->where("id",$request->area_id)->first()->trans_price;
            if($request->feedback !=null){
                 $request["feedback_date"]=now();
            }
            $order->update($request->all());
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('orders.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offer = Order::findOrFail($id);
            $offer->update([
                'deleted_by'    => auth()->user()->id,
                'delete_date'   => now(),
            ]);
            // $product->delete();

            session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route($this->getClassNameFromModel() . '.index');
    }
    
   
}
