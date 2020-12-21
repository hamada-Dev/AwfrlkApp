<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\BackEnd\BackEndController;
use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Null_;

class OrderDetailsController extends BackEndController
{

    public function __construct(OrderDetail $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {

        $rows = $this->model;
        $rows = $this->filter($rows);

        $rows = $rows->whereHas('order')->when($request->order_id, function ($query) use ($request) {
            $query->where('order_id', $request->order_id);
        })->paginate(5);

        
        $module_name_plural=$this->getClassNameFromModel();
        $module_name_singular=$this->getSingularModelName();

        return view('back-end.'.$this->getClassNameFromModel().'.index', compact('rows', 'module_name_singular', 'module_name_plural'));

    } //end of index

    public function create()
    {
        $module_name_plural=$this->getClassNameFromModel();
        $module_name_singular=$this->getSingularModelName();
        $append =$this->append();
        $products=Product::all();
        $orders=Order::all();   
         return view('back-end.'.$this->getClassNameFromModel().'.create', compact('orders','products','module_name_singular', 'module_name_plural'))->with($append);
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

            'amount' => ['required'],
            'product_id' =>['required', 'numeric','exists:products,id'],
            'order_id' =>['required', 'numeric','exists:orders,id'],

        ]);
        // delivery_price is limit from area id
        $request["price"]=floatval(Product::select("price")->where("id",$request->product_id)->first()->price) * floatval($request->amount);
        $this->model->create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('orderdetails.index');
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
        $products=Product::all();
        $orders=Order::all();  
                return view('back-end.'.$this->getClassNameFromModel().'.edit', compact('products','orders','row', 'module_name_singular', 'module_name_plural'))->with($append);
    }
    public function update(Request $request,  $order)
    {
        $request->validate([

            'amount' => ['required'],
            'product_id' =>['required', 'numeric','exists:products,id'],
            'order_id' =>['required', 'numeric','exists:orders,id'],

        ]);
        // delivery_price is limit from area id
        $request["price"]=floatval(Product::select("price")->where("id",$request->product_id)->first()->price) * floatval($request->amount);

            $this->model->find($order)->update($request->all());
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('orderdetails.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offer = OrderDetail::findOrFail($id);
            $offer->update([
                'deleted_by'    => auth()->user()->id,
                'delete_date'   => now(),
            ]);
            // $product->delete();

            session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route($this->getClassNameFromModel() . '.index');
    }

}
