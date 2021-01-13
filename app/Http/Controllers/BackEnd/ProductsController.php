<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\BackEnd\BackEndController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Null_;

class ProductsController extends BackEndController
{

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }




    public function index(Request $request)
    {
        //get all data of Model
        $rows = $this->model;
        $rows = $this->filter($rows);

        $rows = $rows->whereHas('category')->when($request->category_id, function ($query) use ($request) {
            $query->where('category_id', $request->category_id);
        })->latest()->paginate(5);

        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $rows;

        return view('back-end.' . $this->getClassNameFromModel() . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    } //end of index


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'category_id'   =>  ['required', 'numeric', 'exists:categories,id'],
            'image' => ['image'],
            'unit' => ['required', Rule::in(['kilo', 'liter', 'number'])],
            'price' => ['required', 'numeric'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $request_data =  $request->except(['image', '_token']);

        // store image  products_images
        if ($request->image) {
            $this->uploadImage($request);
            $request_data['image'] = $request->image->hashName();
        } //end of if
        else {
            $request_data['image'] = "default.png";
        }

        $request_data['added_by'] = auth()->user()->id;
        $this->model->create($request_data);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('products.index');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'category_id'   =>  ['required', 'numeric', 'exists:categories,id'],
            'image' => ['image'],
            'unit' => ['required', Rule::in(['kilo', 'liter', 'number'])],
            'price' => ['required', 'numeric'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $request_data =  $request->except(['image', '_token']);

        if ($request->image) {
            if ($product->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/products_images/' . $product->image);
            }
            $this->uploadImage($request);

            $request_data['image'] = $request->image->hashName();
        } //end of if

        // check for update price to add it in productUpdate
        try {
            DB::beginTransaction();
            if ($product->price != $request->price)
                $product->ProductUpdate()->create([
                    'price' =>  $product->price,
                    'updated_by' =>  auth()->user()->id,
                ]);

            $product->update($request_data);
            DB::commit();

            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('products.index');
        } catch (\Exception $ex) {
            DB::rollback();
            throw $ex;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $product = Product::findOrFail($id);
        if ($product->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/products_images/' . $product->image);
        }

        $product->update([
            'deleted_by'    => auth()->user()->id,
            'delete_date'   => now(),
        ]);
        // $product->delete();

        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route($this->getClassNameFromModel() . '.index');
    }

    protected function uploadImage($request)
    {

        $img = \Intervention\Image\Facades\Image::make($request->image)->resize(912, 872);

        $img->save(public_path('uploads/products_images/' . $request->image->hashName()));

    }
}
