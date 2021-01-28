<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductRecourse;
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

        if ($searchProduct)
            return $this->sendResponse(ProductRecourse::collection($searchProduct), 200);
        else
            return $this->sendError('theres No data  Yet', 400);
    }
}
