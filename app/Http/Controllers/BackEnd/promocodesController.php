<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\BackEnd\BackEndController;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\User;
use App\Models\Promocode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Null_;

class promocodesController extends BackEndController
{

    public function __construct(Promocode $model)
    {
        parent::__construct($model);
    }


    public function index(Request $request)
    {
        //get all data of Model
        $rows = $this->model;
        $rows = $this->filter($rows);

        $rows = $rows->latest()->paginate(PAG_COUNT);

        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $rows;

        return view('back-end.' . $this->getClassNameFromModel() . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    } //end of index

    public function create(Request $request)
    {
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        $append = $this->append();
        $users = User::where('group', 'user')->get();
        $areas = Area::select(['id', 'name'])->get();

        return view('back-end.' . $this->getClassNameFromModel() . '.create', compact('areas', "users", 'module_name_singular', 'module_name_plural'))->with($append);
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
            'name' => ['required', 'max:100', 'min:5'],
            'confirm'   =>  ['required', 'numeric', rule::in([0, 1])],
            'discount' => ['required', 'numeric'],
            'end_date' => ['required', 'date'],
            'area_id'   => ['required', 'exists:areas,id'],
        ]);
        $request['added_by'] = auth()->user()->id;
        // $request['serial'] = uniqid("Awfrlk_");
        $request['serial'] = 'A-' . intval(time() / random_int(88, 968));


        $this->model->create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('promocodes.index');
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
        $users = User::where('group', 'user')->get();

        $areas = Area::select(['id', 'name'])->get();
        return view('back-end.' . $this->getClassNameFromModel() . '.edit', compact('areas', 'users', 'row', 'module_name_singular', 'module_name_plural'))->with($append);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:100', 'min:5'],
            'confirm'   =>  ['required', 'numeric', rule::in([0, 1])],
            'end_date' => ['required', 'date'],
            'discount' => ['required', 'numeric'],
            'area_id'   => ['required', 'exists:areas,id'],
        ]);
        $request['added_by'] = auth()->user()->id;
        $promo = $this->model->find($id);
        $promo->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('promocodes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $promo = Promocode::findOrFail($id);
        $promo->update([
            'deleted_by'    => auth()->user()->id,
            'delete_date'   => now(),
        ]);
        // $product->delete();

        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route($this->getClassNameFromModel() . '.index');
    }
}
