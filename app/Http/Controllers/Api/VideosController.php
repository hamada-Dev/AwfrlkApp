<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;

class VideosController extends Controller
{
    public function allVideos(){
        $videos = Video::withCount('comments')->orderBy('id', 'desc')->paginate(3);
        return response(['all_videos'=>$videos]);
    } //end of all trips

    public function findVideo($id){
        $video = Video::withCount('comments')->findOrFail($id);
        $comments = $video->comments()->orderBy('id', 'desc')->paginate(1);
        return response(['video'=>$video, 'comments'=>$comments]);
    } //end of all trips
}
