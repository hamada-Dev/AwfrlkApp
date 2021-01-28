<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryRecourse;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function allCategories(Request $request){
        $request->parent_id = !$request->parent_id ? 0 : $request->parent_id;
        $category = Category::where('parent_id', $request->parent_id)->get();
        $category = CategoryRecourse::collection($category);
        return response(['all_categories'=>$category]); 
    } //end of all allCategories
}
