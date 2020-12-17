<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class BackEndController extends Controller
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        //get all data of Model
        $rows = $this->model;
        $rows = $this->filter($rows);
        $rows = $rows->paginate(5);

        $module_name_plural=$this->getClassNameFromModel();
        $module_name_singular=$this->getSingularModelName();

        return view('back-end.'.$this->getClassNameFromModel().'.index', compact('rows', 'module_name_singular', 'module_name_plural'));

    } //end of index

    public function edit($id)
    {
        $module_name_plural=$this->getClassNameFromModel();
        $module_name_singular=$this->getSingularModelName();
        $append =$this->append();
        $row=$this->model->findOrFail($id);

        return view('back-end.'.$this->getClassNameFromModel().'.edit', compact('row', 'module_name_singular', 'module_name_plural'))->with($append);
    } //end of edit

    public function destroy($id)
    {
        $this->model->findOrFail($id)->delete();

        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route($this->getClassNameFromModel().'.index');

    } //end of destroy function

    public function create()
    {
        $module_name_plural=$this->getClassNameFromModel();
        $module_name_singular=$this->getSingularModelName();
        $append =$this->append();

        return view('back-end.'.$this->getClassNameFromModel().'.create', compact('module_name_singular', 'module_name_plural'))->with($append);
    } //end of create

    protected function filter($rows){

        return $rows;
    }
    public function getClassNameFromModel(){

        return Str::plural($this->getSingularModelName());

    }//end of get class name

    public function getSingularModelName(){

        return strtolower(class_basename($this->model));

    }//end of get singular model name

    protected function append(){
        return [];
    } //end of append
}
