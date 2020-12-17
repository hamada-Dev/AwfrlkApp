<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Video;

class CategoriesController extends Controller
{
    public function allCategories(){
        $category = Category::all();
        return response(['all_categories'=>$category]);
    } //end of all trips

    public function findVideo($id){
        $video = Video::withCount('comments')->findOrFail($id);
        $comments = $video->comments()->orderBy('id', 'desc')->paginate(1);
        return response(['video'=>$video, 'comments'=>$comments]);
    } //end of all trips
}
