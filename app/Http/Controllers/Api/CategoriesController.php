<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryRecourse;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function allCategories(){
        $category = CategoryRecourse::collection(Category::get());
        return response(['all_categories'=>$category]); 
    } //end of all allCategories
    
}
