<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\ProductUpdate;
use Illuminate\Http\Request;

class ProductUpdatesController extends BackEndController
{
    public function __construct(ProductUpdate $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {
        //get all data of Model
        $rows = $this->model;
        $rows = $this->filter($rows);
        $rows = $rows->with('product')->when($request->product_id, function($query) use($request){
            return $query->where('product_id', $request->product_id);
        })->latest()->paginate(5);

        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();

        return view('back-end.' . $this->getClassNameFromModel() . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    } //end of index

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return null;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductUpdate  $productUpdate
     * @return \Illuminate\Http\Response
     */
    public function show(ProductUpdate $productUpdate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductUpdate  $productUpdate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductUpdate $productUpdate)
    {
        //
    }

}
