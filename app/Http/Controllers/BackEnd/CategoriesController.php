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
        // dd( ini_get('date.timezone') );
        // dd( ini_get('intl.version') );
        //get all data of Model
        $rows = $this->model;

        // $rows = $rows->where('parent_id', 0)->with('product')->latest()->paginate(PAG_COUNT);

        $request->parent_id = !$request->parent_id ? 0 : $request->parent_id;
        // return $request->parent_id;
        $rows = $rows->where('parent_id', $request->parent_id)->with('product')->latest()->paginate(PAG_COUNT);

        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();


        return view('back-end.' . $this->getClassNameFromModel() . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    } //end of index



    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:500'],
            'parent_id'   => ['nullable', 'numeric',],
            // 'parent_id'   => ['nullable', 'numeric', 'exists:categories,id'],
            'image'       => ['image'],
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
            'parent_id'   => ['nullable', 'numeric',],
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

    public function destroy($id, Request $request)
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
        $img = \Intervention\Image\Facades\Image::make($request->image)->resize(912, 872);

        $img->save(public_path('uploads/categories_images/' . $request->image->hashName()));
    }
}
