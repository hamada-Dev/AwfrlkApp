<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductRecourse;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $cat = Category::find($id);
        if ($cat) {


            $products = Product::when($request->prosearch, function ($query) use ($request) {
                return $query->where('id', '<>', $request->prosearch);
            })->where('category_id', $id)->get();

            if (isset($request->prosearch)) {
                $prosearch = Product::find($request->prosearch); // get item search on it 
                $products = $products->prepend($prosearch);     // add item in the first of collection
            }

            if ($products->count() > 0)
                return $this->sendResponse(ProductRecourse::collection($products), 'produc data');
            else
                return $this->sendError('200', 'this category have ZERO product');
        } else {
            return $this->sendError('200', 'this cat is not find ');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
