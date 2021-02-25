<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductRecourse;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchCatProController extends BaseController
{
    public function search(Request $request)
    {
        // $searchProduct = Product::where('category_id', function ($query) use ($request) {
        //     return $query->select('category_id')->where('name', 'like', '%' . $request->search . '%')
        //         ->orwhere('price', 'like', '%' . $request->search . '%')
        //         ->orwhere('description', 'like', '%' . $request->search . '%');
        // })->get();

        $searchProduct = Product::when($request->search, function ($qu) use ($request) {
            return $qu->where('name', 'like', '%' . $request->search . '%')
                ->orwhere('price', 'like', '%' . $request->search . '%')
                ->orwhere('description', 'like', '%' . $request->search . '%');
        })->get();

        // this condition if user search about category
        if ($searchProduct->count() <= 0) {
            $categoryId = Category::select('id')->when($request->search, function ($qu) use ($request) {
                return $qu->where('name', 'like', '%' . $request->search . '%')
                    ->orwhere('description', 'like', '%' . $request->search . '%');
            })->get();
            if ($categoryId->count() > 0) {
                $searchProduct = Product::when($categoryId, function ($qu) use ($categoryId) {
                    return $qu->where('category_id', $categoryId[0]->id);
                })->get();
            }
        }

        if ($searchProduct)
            return $this->sendResponse(ProductRecourse::collection($searchProduct), 200);
        else
            return $this->sendError('theres No data  Yet', 200);
    }
}
