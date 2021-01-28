<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\BackEnd\BackEndController;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Null_;

class OffersController extends BackEndController
{

    public function __construct(Offer $model)
    {
        parent::__construct($model);
    }


    public function index(Request $request)
    {
        //get all data of Model
        $rows = $this->model;
        $rows = $this->filter($rows);

        $rows = $rows->whereHas('area')->when($request->area_id, function ($query) use ($request) {
            $query->where('area_id', $request->area_id);
        })->paginate(PAG_COUNT);

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
        $areas = Area::all();
        return view('back-end.' . $this->getClassNameFromModel() . '.create', compact("areas", 'module_name_singular', 'module_name_plural'))->with($append);
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
            'price' => ['required', 'numeric', 'max:10000', 'min:2'],
            'name' => ['required', 'max:100', 'min:5'],
            'trips_count'   =>  ['required', 'numeric', 'min:1'],
            'offer_days'   =>  ['required', 'numeric', 'max:60', 'min:1'],
            'avilable' => ['required', 'numeric'],
            'area_id' => ['required', 'numeric', 'exists:areas,id'],
            'image' => ['nullable', 'image', ],
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

        Offer::create($request_data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('offers.index');
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
        $areas = Area::all();
        return view('back-end.' . $this->getClassNameFromModel() . '.edit', compact('areas', 'row', 'module_name_singular', 'module_name_plural'))->with($append);
    }
    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'name' => ['required', 'max:100', 'min:5'],
            'price' => ['required', 'numeric', 'max:10000', 'min:2'],
            'trips_count'   =>  ['required', 'numeric', 'min:1'],
            'offer_days'   =>  ['required', 'numeric', 'max:60', 'min:1'],
            'avilable' => ['required', 'numeric'],
            'area_id' => ['required', 'numeric', 'exists:areas,id'],
            'image' => ['nullable', 'image', ],
        ]);

        $request_data =  $request->except(['image', '_token']);

        if ($request->image) {
            if ($offer->image != 'order.png') {
                Storage::disk('public_uploads')->delete('/offers_images/' . $offer->image);
            }
            $this->uploadImage($request);

            $request_data['image'] = $request->image->hashName();
        } //end of if


        $offer->update($request_data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('offers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $offer = Offer::findOrFail($id);
        $offer->update([
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

        $img->save(public_path('uploads/offers_images/' . $request->image->hashName()));
    }
}
