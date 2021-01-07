<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SliderResource;
use App\models\Slider;
use Illuminate\Http\Request;

class SliderController extends BaseController
{
    public function slider()
    {
        $sliders = Slider::get();
        if ($sliders->count() > 0)
            return $this->sendResponse(SliderResource::collection($sliders), 'slider fro App');
        else
            return $this->sendError('no data', 'this is no image for slider', 500);
    }
}
