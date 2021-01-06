<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\BackEnd\BackEndController;
use App\Http\Controllers\Controller;
use App\Models\Advance;

use App\Models\User;
use App\Models\Order;
use App\Models\Offer;
use App\Models\Usersalary;

use Illuminate\Http\Request;

class advancesController extends BackEndController
{

    public function __construct(Advance $model)
    {
        parent::__construct($model);
    }


    public function index(Request $request)
    {
        //get all data of Model
        $rows = $this->model;
        $rows = $this->filter($rows);

        $rows = $rows->where('flag', 0)->paginate(5);

        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $rows;

        return view('back-end.' . $this->getClassNameFromModel() . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    } //end of index

    public function create()
    {
        $module_name_plural=$this->getClassNameFromModel();
        $module_name_singular=$this->getSingularModelName();
        $append =$this->append();
        $users=User::where('group','delivery')->get();
        return view('back-end.'.$this->getClassNameFromModel().'.create', compact("users",'module_name_singular', 'module_name_plural'))->with($append);
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
            'user_id' =>['required', 'numeric','exists:users,id'],
            'getmoney' => ['required', 'numeric'],

        ]);
            $request['added_by'] = auth()->user()->id;


        $this->model->create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('advances.index');
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
        $users=User::where('group','delivery')->get();
        return view('back-end.'.$this->getClassNameFromModel().'.edit', compact('users','row', 'module_name_singular', 'module_name_plural'))->with($append);
    }
    public function update(Request $request,$id)
    {
        $request->validate([
            'user_id' =>['required', 'numeric','exists:users,id'],
            'getmoney' => ['required', 'numeric'],

        ]);
            $request['added_by']=auth()->user()->id;
            $advance=$this->model->find($id);
            $advance->update($request->all());
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('advances.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $promo = Advance::findOrFail($id);
            $promo->update([
                'deleted_by'    => auth()->user()->id,
                'delete_date'   => now(),
            ]);
            // $product->delete();

            session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route($this->getClassNameFromModel() . '.index');
    }
    public function countResetMoney($delivery_id ,$created_at, $id)
    {
        // return $delivery_id;
        $orders=Order::where('delivery_id',$delivery_id)->where("created_at",'>',$created_at)->get();

        $advance=$this->model->find($id);
        $sum=0;
        foreach($orders as $order)
        {
            $sum+=$order->delivery_price;
        }
         $advance->givemoney=$advance->getmoney+$sum;
         $advance->save();
         return view('back-end.advances.advance',compact('advance','orders'));

    }
    public function countMoney($advance_id)
    {
        $advance=$this->model->find($advance_id);
        $advance->update([
            'flag'=>1
        ]);
        $rows = $this->model;
        $rows = $rows->where('flag', 0)->paginate(5);
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        return view('back-end.' . $this->getClassNameFromModel() . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
      }

   public function showReport()
   {
       
        return view('back-end.advances.counts');

   }
   public function countAllMoney(Request $request)
   {
    
    if ($request->start_date > $request->end_date) {
        $swap = $request->end_date;
        $request->end_date = $request->start_date;
        $request->start_date = $swap;
    }

    if (isset($request->start_date)) {
        $start_date   = date('Y-m-d h:i:s ', strtotime($request->start_date));
    } else {
        $last2year = time() - (2 * 12 * 30 * 24 * 60 * 60);
        $start_date   = date('Y-m-d h:i:s G', $last2year);
    }

    if (isset($request->end_date)) {
        // $end_date   = date('Y-m-d h:i:s ', (strtotime($request->end_date) + 24 * 60 * 60));
        $end_date   = date('Y-m-d', strtotime($request->end_date)) . ' 23:59:59';
    } else {
        // $end_date = date('Y-m-d h:i:s ', time() + 10*60*60 );
        $end_date = date('Y-m-d', time()) . ' 23:59:59';
    }
    

        $orders=Order::where('created_at', '>=', $start_date)->where('created_at', '<', $end_date)->where('status',1)->get();
        $users=User::all();
        $offers=Offer::where('created_at', '>=', $start_date)->where('created_at', '<', $end_date)->where('avilable',1)->get();
        $salaries=Usersalary::where('moneyDay', '>=', $start_date)->where('moneyDay', '<', $end_date)->get();
        return view('back-end.advances.counts',compact('orders','users','offers','salaries'));                
}
}
