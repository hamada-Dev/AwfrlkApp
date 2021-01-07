<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BackEnd\BackEndController;
use App\models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends BackEndController
{
    public function __construct(Slider $model)
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

        return view('back-end.' . $this->getClassNameFromModel() . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    } //end of index



    public function store(Request $request)
    {
        $request->validate([
            'description' => ['nullable', 'string', 'max:500'],
            'image' => ['required', 'image'],
        ]);

        $request_data =  $request->except(['image', '_token']);

        // store image
        if ($request->image) {

            $this->uploadImage($request);
            $request_data['image'] = $request->image->hashName();
        } //end of if

        $request_data['added_by'] = auth()->user()->id;

        $this->model->create($request_data);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('sliders.index');
    } //end of store

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'description' => ['nullable', 'string', 'max:500'],
            'image' => ['image'],
        ]);

        $request_data =  $request->except(['image', '_token']);
        // store image
        if ($request->image) {
            Storage::disk('public_uploads')->delete('/sliders_images/' . $slider->image);
            $this->uploadImage($request);

            $request_data['image'] = $request->image->hashName();
        } //end of if

        $slider->update($request_data);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('sliders.index');
    } //end of update

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        // Storage::disk('public_uploads')->delete('/sliders_images/' . $slider->image);

        $slider->update([
            'deleted_by'   => auth()->user()->id,
            'delete_date'   => now(),
        ]);
        // $slider->delete();

        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route($this->getClassNameFromModel() . '.index');
    } //end of destroy function

    protected function uploadImage($request)
    {
        $img = \Intervention\Image\Facades\Image::make($request->image)->resize(800, 500);
        // save file as jpg with medium quality
        $img->save(public_path('uploads/sliders_images/' . $request->image->hashName()), 70);
    }
}
