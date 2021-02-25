<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductRecourse;
use App\Http\Resources\SliderResource;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends BaseController
{
    public function slider()
    {
        $sliders = Slider::get();
        $sliders = SliderResource::collection($sliders);

        $products = Product::where('offer', 1)->get();
        $products = ProductRecourse::collection($products);

        $merged = $sliders->toBase()->merge($products);

        if ($sliders->count() > 0)
            return $this->sendResponse($merged, 'slider fro App');
        else
            return $this->sendError('no data', 'this is no image for slider', 200);
    }
}
