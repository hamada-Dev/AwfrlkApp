<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\BackEnd\BackEndController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Advance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Null_;

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

        $rows = $rows->paginate(5);

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
            'givemoney'   =>  [],

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
            'givemoney'   =>  [],

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

  
}
