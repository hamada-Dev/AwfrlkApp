<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryRecourse;
use App\Http\Resources\OrderUserRecourse;
use App\Models\Area;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{

    public $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userOrder = OrderUserRecourse::collection($this->model->where('client_id', auth()->user()->id)->get());
        if (!empty($userOrder))
            return $this->sendResponse($userOrder, 'orderdata');
        else
            return $this->sendError('300', 'there is no order for this user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ActiveDelivery = User::deliveryActive()->get();

        // this for add order 
        if ($request->product_id) {
            $request->validate([
                'product_id.*'   =>  ['required', 'numeric', 'exists:products,id'],
                // 'area_id'      =>  ['required', 'numeric', 'exists:areas,id'],
            ]);
            try {
                DB::beginTransaction();
                $newOrder = $this->model->create([
                    'client_id'      => auth()->user()->id,
                    'delivery_price' => auth()->user()->area->trans_price,
                    'area_id'        =>  $request->area_id ?? auth()->user()->area_id,
                ]);

                for ($i = 0; $i <  count($request->product_id); $i++) {
                    $newOrder->orderDetails()->create([
                        'amount'     => $request->amount[$i],
                        'price'      => $request->price[$i] * $request->amount[$i],
                        'product_id' => $request->product_id[$i],
                    ]);
                }
                // request of image for pharmacy 
                if ($request->image) {
                    $this->pharmacy($request, $newOrder, $ActiveDelivery);
                }

                DB::commit();
                return $this->sendResponse(['data' => 'add product || pharmacy order   sucessfully', 'Delivery' => DeliveryRecourse::collection($ActiveDelivery)], 200);
            } catch (\Exception $ex) {
                DB::rollback();
                return $this->sendError(['data' => 'cant add this order please try again'], 404);
            }
        } elseif ($request->image) {
            return $this->pharmacy($request, null, $ActiveDelivery);
        } elseif ($request->adress_from) {
            $request->validate([
                'area_id_from'   =>  ['required', 'numeric', 'exists:areas,id'],
                // 'area_id'        =>  ['required', 'numeric', 'exists:areas,id'],
                'product_home.*'   =>  ['required', 'string',],
            ]);

            try {
                DB::beginTransaction();
                $areaTransFrom = Area::select('trans_price')->where('id', $request->area_id_from)->first();

                $newOrder = $this->model->create([
                    'client_id'      =>  auth()->user()->id,
                    'area_id'        =>  $request->area_id ?? auth()->user()->area_id,
                    'area_id_from'   =>  $request->area_id_from,
                    'adress_from'    =>  $request->adress_from,
                    'delivery_price' =>  auth()->user()->area_id == $request->area_id_from ? auth()->user()->area->trans_price : auth()->user()->area->trans_price + $areaTransFrom->trans_price,
                ]);

                for ($i = 0; $i <  count($request->product_home); $i++) {
                    $newOrder->orderDetails()->create([
                        'product_home' => $request->product_home[$i],
                    ]);
                }

                DB::commit();
                return $this->sendResponse(['data' => 'add home order   sucessfully', 'Delivery' => DeliveryRecourse::collection($ActiveDelivery)], 200);
            } catch (\Exception $ex) {
                DB::rollback();
                return $this->sendError(['data' => 'cant add this order please try again'], 404);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function pharmacy($request, $newOrder = null, $ActiveDelivery = null)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'image'   =>  ['image'],
            ]);
            if ($newOrder == null) {
                $newOrder = $this->model->create([
                    'client_id'      => auth()->user()->id,
                    'delivery_price' => auth()->user()->area->trans_price,
                    'area_id'        =>  $request->area_id ?? auth()->user()->area_id,
                ]);
            }
            $this->uploadImage($request);
            $newOrder->orderDetails()->create([
                'image'     => $request->image->hashName(),
            ]);
            DB::commit();
            return $this->sendResponse(['data' => 'add pharmacy order   sucessfully', 'Delivery' => DeliveryRecourse::collection($ActiveDelivery)], 200);
        } catch (\Exception $ex) {
            DB::rollback();
            return $this->sendError(['data' => 'cant add this order please try again'], 404);
        }
    }

    protected function uploadImage($request)
    {
        $img = \Intervention\Image\Facades\Image::make($request->image)->resize(800, 500);
        // save file as jpg with medium quality
        $img->save(public_path('uploads/orders_images/' . $request->image->hashName()), 70);
    }
}
