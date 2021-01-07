<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\BackEnd\BackEndController;
use Illuminate\Http\Request;
use App\Models\Area;

class AreasController extends BackEndController
{
    
    public function __construct(Area $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {
        //get all data of Model
        $rows = $this->model;
        $rows = $this->filter($rows); 
        $rows = $rows->where("parent_id","0")->paginate(5);
        $module_name_plural=$this->getClassNameFromModel();
        $module_name_singular=$this->getSingularModelName();
        $obj=new Area();
        return view('back-end.'.$this->getClassNameFromModel().'.index', compact('obj','rows', 'module_name_singular', 'module_name_plural'));

    } //end of index
   
   //en
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
        $areas=Area::get();
        // $areas=Area::where("parent_id","0")->get();
        return view('back-end.'.$this->getClassNameFromModel().'.create', compact('areas','module_name_singular', 'module_name_plural'))->with($append);
    } //end of create


    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:30','min:5'],
            'trans_price'   =>  ['required', 'numeric','min:1'],
            'parent_id'   =>  ['numeric'],
        ]);
        $request['added_by'] = auth()->user()->id;
        Area::create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('areas.index');
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
        $areas=Area::where("parent_id","0")->get();
        return view('back-end.'.$this->getClassNameFromModel().'.edit', compact('areas','row', 'module_name_singular', 'module_name_plural'))->with($append);
    } //end of edit


    public function update(Request $request, Area $area)
    {
        $request->validate([
            'name' => ['required', 'max:30','min:5'],
            'trans_price'   =>  ['required', 'numeric','min:1'],
            'parent_id'   =>  ['numeric','exists:areas,id'],
        ]);

            $area->update($request->all());
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('areas.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $area = Area::findOrFail($id);
            $area->update([
                'deleted_by'    => auth()->user()->id,
                'delete_date'   => now(),
            ]);
            // $product->delete();

            session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route($this->getClassNameFromModel() . '.index');
    }
    public function childern($parent_id)
    {
        $module_name_plural=$this->getClassNameFromModel();
        $module_name_singular=$this->getSingularModelName();
        $append =$this->append();
        $areas = Area::where("parent_id","0")->paginate(5);
        $rows=Area::where("parent_id",$parent_id)->paginate(5);
        return view('back-end.'.$this->getClassNameFromModel().'.Childern', compact('areas','rows','module_name_singular', 'module_name_plural'))->with($append);

    }
    
}
