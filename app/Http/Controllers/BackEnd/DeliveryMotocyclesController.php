<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Models\DeliveryMotocycle;
use App\Models\User;

class DeliveryMotocyclesController extends BackEndController
{
    public function __construct(DeliveryMotocycle $model)
    {
        parent::__construct($model);
    }




    public function create()
    {
        $module_name_plural=$this->getClassNameFromModel();
        $module_name_singular=$this->getSingularModelName();
        $append =$this->append();
        $users=User::where("group","delivery")->get();
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
            'user_license' => ['required', 'max:10000','min:2','unique:delivery_motocycles'],
            'moto_license'   =>  ['required', 'max:10000','min:1','unique:delivery_motocycles'],
            'moto_number'   =>  ['required','unique:delivery_motocycles'],
            'license_renew_date' =>['required'],
            'license_expire_date' =>['required'],
            'type' =>['required'],
            'color' =>['required'],
            'user_id' => ['required','exists:users,id'],
        ]);
        $request['added_by'] = auth()->user()->id;
        $this->model->create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('deliverymotocycles.index');
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
        $users=User::where("group","delivery")->get();
        return view('back-end.'.$this->getClassNameFromModel().'.edit', compact('users','row', 'module_name_singular', 'module_name_plural'))->with($append);
    }
    public function update(Request $request, DeliveryMotocycle $deliverymotocycle)
    {
        $request->validate([
            'user_license' => ['required', 'max:10000','min:2'],
            'moto_license'   =>  ['required', 'max:10000','min:1'],
            'moto_number'   =>  ['required'],
            'license_renew_date' =>[],
            'license_expire_date' =>[],
            'type' =>['required'],
            'color' =>['required'],
            'user_id' => ['required','exists:users,id'],

        ]);

            $deliverymotocycle->update($request->all());
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('deliverymotocycles.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deliverymotocycle = DeliveryMotocycle::findOrFail($id);
            $deliverymotocycle->update([
                'deleted_by'    => auth()->user()->id,
                'delete_date'   => now(),
            ]);
            // $product->delete();

            session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route($this->getClassNameFromModel() . '.index');
    }

   
}
