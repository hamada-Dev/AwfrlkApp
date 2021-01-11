<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\BackEnd\BackEndController;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Area;
use App\Models\Promocode;
use App\Models\UserOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Null_;

class OredersController extends BackEndController
{

    public function __construct(Order $model)
    {
        parent::__construct($model);
    }




    public function index(Request $request)
    {
        // return $request;
        //get all data of Model
        $rows = $this->model;
        $rows = $this->filter($rows);
        $rows = $rows-> when($request->delivery_id, function ($query) use ($request) {
            $query->where('delivery_id', $request->delivery_id)->where('created_at','>', $request->created_at);
        })->latest()->paginate(4);
       
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $rows;
        $users=User::all();
        return view('back-end.' . $this->getClassNameFromModel() . '.index', compact("users",'rows', 'module_name_singular', 'module_name_plural'));
    } //end of index

    public function create(Request $request)
    {
        $module_name_plural=$this->getClassNameFromModel();
        $module_name_singular=$this->getSingularModelName();
        $append =$this->append();
        $users=User::where("group","user")->get();
        $ActiveDelivery = User::deliveryActive()->get();
        $delivers=User::where("group","delivery")->where("delivery_status",1)->get();
        $areas=Area::all();       
         return view('back-end.'.$this->getClassNameFromModel().'.create', compact('users','delivers','areas','module_name_singular', 'module_name_plural'))->with($append);
    } //en
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check if user has promocode or not 
        $checkPromo = $this->checkUserPromo($request);
        //  check if user has offer or not 
        $checkOffer = $this->checkUserOffer($request->client_id);
        
        // this is for col type in order 
        $orderType = 0;

        if (!empty($checkPromo)) {
            $checkPromo->update(['confirm'=>0]);
            $orderType = 2;
        } elseif (!empty($checkOffer)) {
            $newDeceremnt=$checkOffer->decrement_trip-1;
            $checkOffer->update(['decrement_trip'=>$newDeceremnt]);
            $orderType = 1;
        }

        $request->validate([

            'status' => ['numeric', Rule::in([0, 1])],
            'end_shoping_date' => [],
            'arrival_date'   =>  [],
            'feedback'   =>  ['required','max:250','min:5'],
            'client_id' =>['required', 'numeric','exists:users,id'],
            'area_id' =>['required', 'numeric','exists:areas,id'],

        ]);
        // delivery_price is limit from area id
        $order_type=$request->order_type;
        // $request["delivery_price"]=Area::select("trans_price")->where("id",$request->area_id)->first()->trans_price;
        $delivery_price = $this->deliveryPriceHOHO($request, $orderType, $checkOffer, $checkPromo);
        $request['delivery_price'] =$delivery_price['deliveryPrice'];
        $request['offer_or_promo_id'] =$delivery_price['offerOrPromoId'];
        $request['type']= $delivery_price['orderTyoe'];

        if($request->feedback !=null){
            $request["feedback_date"]=now();
       }
       $request=$request->except('order_type');

        $this->model->create($request);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('orderdetails.show',$order_type);
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
        $module_name_plural=$this->getClassNameFromModel();
        $module_name_singular=$this->getSingularModelName();
        $append =$this->append();
        $row=$this->model->findOrFail($id);
        $users=User::where("group","user")->get();
        $delivers=User::where("group","delivery")->where("delivery_status",1)->get();
        $areas=Area::all();  
                return view('back-end.'.$this->getClassNameFromModel().'.edit', compact('users','delivers','areas','row', 'module_name_singular', 'module_name_plural'))->with($append);
    }
    public function update(Request $request, Order $order)
    {
        $request->validate([

            'status' => ['numeric', Rule::in([0, 1])],
            'end_shoping_date' => [],
            'arrival_date'   =>  [],
            'feedback'   =>  ['max:250','min:5'],
            'client_id' =>['required', 'numeric','exists:users,id'],
            'area_id' =>['required', 'numeric','exists:areas,id'],

        ]);
        // delivery_price is limit from area id
            $request["delivery_price"]=Area::select("trans_price")->where("id",$request->area_id)->first()->trans_price;
            if($request->feedback !=null){
                 $request["feedback_date"]=now();
            }
            $request=$request->except('order_type');

            $order->update($request);
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('orders.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offer = Order::findOrFail($id);
            $offer->update([
                'deleted_by'    => auth()->user()->id,
                'delete_date'   => now(),
            ]);
            // $product->delete();

            session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route($this->getClassNameFromModel() . '.index');
    }

    protected function checkUserPromo($request)
    {
        $avilablePromo = Promocode::where('user_id', $request->client_id)
            ->where('confirm', 1)
            ->where('area_id', $request->area_id)->first();
            
        return $avilablePromo;
    }

    protected function checkUserOffer($id)
    {
        $avilableOffer = UserOffer::where('user_id', $id)
            ->where('decrement_trip', '>', 0)
            ->where('end_date', '>', now())->first();
        return $avilableOffer;
    }
   protected function deliveryPriceHOHO($request, $orderType, $checkOffer = null, $checkPromo = null)
    {
        $areaTransFrom = Area::select('trans_price')->where('id', $request->area_id_from)->first();
        $areaTransTo = Area::select('trans_price')->where('id', $request->area_id)->first();


        if ($orderType == 1) { // if user have an offer 
            if ($checkOffer->Offer->area_id  ==$request->area_id && $checkOffer->Offer->area_id == $request->area_id_from) {
                $deliveryPrice = 0;
                $offerOrPromoId = $checkOffer->id;
                $orderTyoe  = 1;
            } else {
                $deliveryPrice =$areaTransTo['trans_price'] + $areaTransFrom['trans_price'];
                $offerOrPromoId = null;
                $orderTyoe  = 0;
            }
        } elseif ($orderType == 2) { // if user have promo 
            if ($checkPromo->area_id  == $request->area_id && $checkPromo->area_id  == $request->area_id_from) {
                $deliveryPrice = $areaTransTo['trans_price'] * $checkPromo->discount / 100;
                $offerOrPromoId = $checkPromo->id;
                $orderTyoe  = 2;
            } else {
                $deliveryPrice = $areaTransTo['trans_price'] + $areaTransFrom['trans_price'];
                $offerOrPromoId = null;
                $orderTyoe  = 0;
            }
        } else { // if user not have promo or offer 

            if ($request->area_id == $request->area_id_from) {
                $deliveryPrice = $areaTransTo['trans_price'];
                $offerOrPromoId = null;
                $orderTyoe  = 0;
            } else {
                $deliveryPrice = $areaTransTo['trans_price'] + $areaTransFrom['trans_price'];
                $offerOrPromoId = null;
                $orderTyoe = 0;
            }
        }

        $deliveryPriceData = ['deliveryPrice' => $deliveryPrice, 'offerOrPromoId' => $offerOrPromoId, 'orderTyoe' => $orderTyoe];

        return $deliveryPriceData;
    }

}
