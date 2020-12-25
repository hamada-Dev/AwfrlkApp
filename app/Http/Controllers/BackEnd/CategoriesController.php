<?php

namespace App\Http\Controllers\BackEnd;


use App\Models\Category;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoriesController extends BackEndController
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {
        //get all data of Model
        $rows = $this->model;
        $rows = $this->filter($rows);
        $rows = $rows->with('product')->paginate(5);

        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();

        return view('back-end.' . $this->getClassNameFromModel() . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    } //end of index



    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:500'],
            'image' => ['image'],
        ]);

        $request_data =  $request->except(['image', '_token']);

        // store image
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
        return redirect()->route('categories.index');
    } //end of store

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:500'],
            'image' => ['image'],
        ]);

        $request_data =  $request->except(['image', '_token']);
        // store image
        if ($request->image) {

            if ($category->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/categories_images/' . $category->image);
            }
            $this->uploadImage($request);

            $request_data['image'] = $request->image->hashName();
        } //end of if

        $category->update($request_data);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('categories.index');
    } //end of update

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if ($category->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/categories_images/' . $category->image);
        }
        $category->update([
            'deleted_by'   => auth()->user()->id,
            'delete_date'   => now(),
        ]);
        // $category->delete();

        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route($this->getClassNameFromModel() . '.index');
    } //end of destroy function

    protected function uploadImage($request)
    {
        \Intervention\Image\Facades\Image::make($request->image)->save(public_path('uploads/categories_images/' . $request->image->hashName()));
        //            ->resize(300, null, function ($constraint) {
        //            $constraint->aspectRatio();

    }
}
