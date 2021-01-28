<?php

namespace App\Http\Controllers\backend;

use App\Events\AdminForceDeliveryEvent;
use App\Http\Controllers\BackEnd\BackEndController;
use App\Http\Resources\OrderDetailsRecourse;
use App\Http\Resources\UserResource;
use App\Models\Area;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promocode;
use App\Models\User;
use App\Models\UserOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderDetailsController extends BackEndController
{

    public function __construct(OrderDetail $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {

        $rows = $this->model;
        $rows = $this->filter($rows);

        $rows = $rows->whereHas('order')->when($request->order_id, function ($query) use ($request) {
            $query->where('order_id', $request->order_id);
        })->paginate(PAG_COUNT);


        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        $orderType = 1;
        $orederCheckType = $this->model->where('order_id', $request->order_id)->first();
        if ($orederCheckType->amount != null) {
            $orderType = 0;
        } elseif ($orederCheckType->image != null) {
            $orderType = 2;
        } else {
            $orderType = 1;
        }
        return view('back-end.' . $this->getClassNameFromModel() . '.index', compact('orderType', 'rows', 'module_name_singular', 'module_name_plural'));
    } //end of index

    public function create(Request $request)
    {
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        $append = $this->append();
        $products = Product::all();
        // $orders = Order::all();
        return view('back-end.' . $this->getClassNameFromModel() . '.create', compact('products', 'module_name_singular', 'module_name_plural'))->with($append);
    } //en
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id) // i use this method for cancel order when admin cancel order i have to make delivery active becouse i make it busy for this order 
    {
        $checkDelivery = User::find($id);
        if ($checkDelivery) {
            $this->changeDeliveryStatusmakeNotActive($checkDelivery);
            session()->flash('success', 'تم الغاء الطلب بنجاح ');
            return redirect()->route('orders.index');
        } else {
            session()->flash('error', 'هناك خطا أثناء الغاء الطلب برجاء المحاوله مره اخري');
            return redirect()->route('orders.index');
        }
    }
    public function store(Request $request)
    {

        // return $request;
        if (!isset($request->client_id)) {
            session()->flash('error', 'حدث خطا ما برجاء المحاوله مره اخري');
            return redirect()->route('orders.create');
        }
        // get all active delivery 
        $ActiveDelivery = User::find($request->delivery_id);
        $clientOrder    = User::find($request->client_id);

        // check if user has promocode or not 
        $checkPromo = $this->checkUserPromo($request->client_id, $clientOrder);
        //  check if user has offer or not 

        $checkOffer = $this->checkUserOffer($request->client_id);

        // this is for col type in order 
        $orderType = 0;

        if (!empty($checkPromo)) {
            $orderType = 2;
        } elseif (!empty($checkOffer)) {
            $orderType = 1;
        }

        if ($request->adress_from) {
            $request->validate([
                'area_id_from'   =>  ['required', 'numeric', 'exists:areas,id'],
                // 'area_id'        =>  ['required', 'numeric', 'exists:areas,id'],
                'product_home'   =>  ['required', 'string', 'max:254'],
                'adress_from'   =>  ['required', 'string', 'max:222'],
            ]);

            try {
                DB::beginTransaction();
                $deliveyPrice = $this->deliveryPriceHOHO($request, $orderType, $clientOrder, $checkOffer, $checkPromo);
                $newOrder = Order::create([
                    'client_id'      =>  $request->client_id,
                    'delivery_id'    =>  $request->delivery_id,
                    'area_id'        =>  $request->area_id ?? $clientOrder->area_id,
                    'adress'         =>  $request->adress ??  $clientOrder->adress,
                    'area_id_from'   =>  $request->area_id_from,
                    'adress_from'    =>  $request->adress_from,
                    'delivery_price' =>  $deliveyPrice['deliveryPrice'],
                    'offer_or_promo_id' =>  $deliveyPrice['offerOrPromoId'],
                    'type'           => $deliveyPrice['orderTyoe'],
                ]);

                $newOrder->orderDetails()->create([
                    'product_home' => $request->product_home,
                    'description'  => $request->description,
                ]);


                $order_details   =  OrderDetailsRecourse::collection($newOrder->orderDetails()->get());
                $order_client    =  new UserResource(User::find($newOrder->client_id));
                $order_delivery  =  new UserResource(User::find($newOrder->delivery_id));
                $alert           = 'admin Forcing this delivery to take  this order';
                ////////////////////////////////////////////////
                $this->makeEvent($order_details, $order_delivery, $order_client, $alert);
                ////////////////////////////////////////////////

                // this is update offer table or promocode 
                if ($deliveyPrice['offerOrPromoId'] != null) {
                    $this->updatePromoOffer($orderType, $checkOffer, $checkPromo);
                }

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return $ex;
            }
        } elseif ($request->image) {
            try {
                DB::beginTransaction();

                $newOrder = $this->insertOredr($request, $orderType, $clientOrder, $checkOffer, $checkPromo);
                $this->uploadImage($request);
                $newOrder->orderDetails()->create([
                    'image'       => $request->image->hashName(),
                    'description' => $request->description,
                ]);

                // this is update offer table or promocode 
                if ($newOrder->offer_or_promo_id != null)
                    $this->updatePromoOffer($orderType, $checkOffer, $checkPromo);

                $order_details   =  OrderDetailsRecourse::collection($newOrder->orderDetails()->get());
                $order_client    =  new UserResource(User::find($newOrder->client_id));
                $order_delivery  =  new UserResource(User::find($newOrder->delivery_id));
                $alert           = 'admin Forcing this delivery to take  this order';
                ////////////////////////////////////////////////
                $this->makeEvent($order_details, $order_delivery, $order_client, $alert);
                ////////////////////////////////////////////////

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return $ex;
            }
        } else {
            try {
                DB::beginTransaction();

                $newOrder = $this->insertOredr($request, $orderType, $clientOrder, $checkOffer, $checkPromo);

                for ($i = 0; $i < count($request->product_id); $i++) {
                    $newOrder->orderDetails()->create([
                        'amount'      => $request['amount'][$i],
                        'price'       => $request['price'][$i],
                        'product_id'  => $request['product_id'][$i],
                        // 'description' => $request['description'][$i],
                    ]);
                }

                // this is update offer table or promocode 
                if ($newOrder->offer_or_promo_id != null)
                    $this->updatePromoOffer($orderType, $checkOffer, $checkPromo);

                $order_details   =  OrderDetailsRecourse::collection($newOrder->orderDetails()->get());
                $order_client    =  new UserResource(User::find($newOrder->client_id));
                $order_delivery  =  new UserResource(User::find($newOrder->delivery_id));
                $alert           = 'admin Forcing this delivery to take  this order';
                ////////////////////////////////////////////////
                $this->makeEvent($order_details, $order_delivery, $order_client, $alert);
                ////////////////////////////////////////////////

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return $ex;
            }
        }


        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('orders.index');
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
        $row = $this->model->where('order_id', $id)->get();
        // return $row;
        $products = Product::all();
        $orders = Order::find($id);
        return view('back-end.' . $this->getClassNameFromModel() . '.edit', compact('products', 'orders', 'row', 'module_name_singular', 'module_name_plural'))->with($append);
    }

    public function update(Request $request,  $id)
    {
        // return $request;
        $updateOrder = Order::find($id);


        if ($request->orderType == 1) { // 1 mean this is a from home to home 
            $updateOrder->update([
                'area_id_from' => $request->area_id_from,
                'adress_from'  => $request->adress_from,
            ]);
            $updateOrder->orderDetails()->update([
                'product_home'  => $request->product_home,
                'description'   =>  $request->description,
            ]);
        } elseif ($request->orderType == 2) { // 2 mean this is a pharmacy 
            if ($request->image) {
                Storage::disk('public_uploads')->delete('/orders_images/' . $updateOrder->orderDetails[0]->image);
                $this->uploadImage($request);
                $request_data['image'] = $request->image->hashName();
            }
            $updateOrder->orderDetails()->update([
                'description'  => $request->description,
                'image'        =>  $request_data['image'] ??  $updateOrder->orderDetails[0]->image,
            ]);
        } else {
            $updateOrder->orderDetails()->delete();
            for ($i = 0; $i < count($request->product_id); $i++) {
                $updateOrder->orderDetails()->create([
                    'amount'      => $request['amount'][$i],
                    'price'       => $request['price'][$i],
                    'product_id'  => $request['product_id'][$i],
                    // 'description' => $request['description'][$i],
                ]);
            }
        }
        // $updateOrder->orderDetails[0]->image

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        return 'make update plz be patient';
    }



    protected function checkUserPromo($id, $clientOrder)
    {
        $avilablePromo = Promocode::where('user_id', $id)
            ->where('confirm', 1)
            ->where('area_id', $clientOrder->area_id)->first();
        return $avilablePromo;
    }

    protected function checkUserOffer($id)
    {
        $avilableOffer = UserOffer::where('user_id', $id)
            ->where('decrement_trip', '>', 0)
            ->where('end_date', '>', now())->first();
        return $avilableOffer;
    }



    protected function updatePromoOffer($orderType, $checkOffer, $checkPromo)
    {
        if ($orderType == 1) { // this is for decrement offer
            $checkOffer->update([
                'decrement_trip' => $checkOffer->decrement_trip - 1,
            ]);
        } elseif ($orderType == 2) { // this is for confirm the promocode
            $checkPromo->update([
                'confirm'   => 0,
            ]);
        }
    }

    protected function deliveryPriceHOHO($request, $orderType, $clientOrder, $checkOffer = null, $checkPromo = null)
    {
        $areaTransFrom = Area::select('trans_price')->where('id', $request->area_id_from)->first();


        if ($orderType == 1) { // if user have an offer 
            if ($checkOffer->Offer->area_id  == $clientOrder->area_id && $checkOffer->Offer->area_id == $request->area_id_from) {
                $deliveryPrice = 0;
                $offerOrPromoId = $checkOffer->id;
                $orderTyoe  = 1;
            } else {
                $deliveryPrice = $clientOrder->area->trans_price + $areaTransFrom['trans_price'];
                $offerOrPromoId = null;
                $orderTyoe  = 0;
            }
        } elseif ($orderType == 2) { // if user have promo 
            if ($checkPromo->area_id  == $clientOrder->area_id && $checkPromo->area_id  == $request->area_id_from) {
                $deliveryPrice = $clientOrder->area->trans_price * $checkPromo->discount / 100;
                $offerOrPromoId = $checkPromo->id;
                $orderTyoe  = 2;
            } else {
                $deliveryPrice = $clientOrder->area->trans_price + $areaTransFrom['trans_price'];
                $offerOrPromoId = null;
                $orderTyoe  = 0;
            }
        } else { // if user not have promo or offer 

            if ($clientOrder->area_id == $request->area_id_from) {
                $deliveryPrice = $clientOrder->area->trans_price;
                $offerOrPromoId = null;
                $orderTyoe  = 0;
            } else {
                $deliveryPrice = $clientOrder->area->trans_price + $areaTransFrom['trans_price'];
                $offerOrPromoId = null;
                $orderTyoe = 0;
            }
        }

        $deliveryPriceData = ['deliveryPrice' => $deliveryPrice, 'offerOrPromoId' => $offerOrPromoId, 'orderTyoe' => $orderTyoe];

        return $deliveryPriceData;
    }




    protected function insertOredr($request, $orderType, $clientOrder, $checkOffer = null, $checkPromo = null)
    {
        if ($orderType == 1) { // if user have an offer 
            if ($checkOffer->Offer->area_id  == $clientOrder->area_id || $checkOffer->Offer->area_id == $request->area_id) {
                $deliveryPrice = 0;
                $offerOrPromoId = $checkOffer->id;
                $checkOrderType = 1;
            } else {
                $deliveryPrice = $clientOrder->area->trans_price;
                $offerOrPromoId = null;
                $checkOrderType = 0;
            }
        } elseif ($orderType == 2) { // if user have promo 
            if ($checkPromo->area_id  == $clientOrder->area_id || $checkPromo->area_id  == $request->area_id) {
                $deliveryPrice = $clientOrder->area->trans_price * $checkPromo->discount / 100;
                $offerOrPromoId = $checkPromo->id;
                $checkOrderType = 2;
            } else {
                $deliveryPrice = $clientOrder->area->trans_price;
                $offerOrPromoId = null;
                $checkOrderType = 0;
            }
        } else { // if user not have promo or offer 
            $deliveryPrice = $clientOrder->area->trans_price;
            $offerOrPromoId = null;
            $checkOrderType = 0;
        }
        $newOrder = Order::create([
            'client_id'      => $request->client_id,
            'delivery_id'    => $request->delivery_id,
            'delivery_price' => $deliveryPrice,
            'area_id'        => $request->area_id ?? $clientOrder->area_id,
            'type'           => $checkOrderType,
            'offer_or_promo_id' => $offerOrPromoId,
        ]);

        return $newOrder;
    }


    // event for take order 
    protected function makeEvent($myOrder, $deliveryData, $userData, $alert)
    {
        $data = [
            'order_detail'     => $myOrder,
            'delivery_data'    => $deliveryData,
            'user_data'        => $userData,
            'alert'            => $alert,
        ];
        event(new AdminForceDeliveryEvent($data));
    }

    protected function uploadImage($request)
    {
        $img = \Intervention\Image\Facades\Image::make($request->image)->resize(800, 500);
        // save file as jpg with medium quality
        $img->save(public_path('uploads/orders_images/' . $request->image->hashName()), 70);
    }


    // admin cancel this order so delivery have to be active to take any order 
    protected function changeDeliveryStatusmakeNotActive($ActiveDelivery)
    {
        $ActiveDelivery->update([
            'delivery_status'   => 1,
        ]);
        $deliveryStatus = $ActiveDelivery->deliveryStatus()->orderBy('created_at', 'DESC')->first();

        $deliveryStatus->update([
            'updated_at'    => now(),
        ]);
        $ActiveDelivery->deliveryStatus()->create([
            'status'    => 1,
        ]);
    }
}
