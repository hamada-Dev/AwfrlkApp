<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use App\Models\Destination;
use App\Models\Hotel;
use App\Models\ProgramCart;
use App\Models\Room;
use App\Models\Roomcart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HotelsController extends BaseController
{
    public function show($destination_id)
    {
        $hotels = Hotel::where('destination_id',$destination_id)->get();

        return response(['all_hotels'=>$hotels]);
    }

    public function destinations()
    {
        $rows = Destination::all();
        return response(['all_destinations'=>$rows]);
    }
    public function findHotel( Request $request)
    {
        $datefrom = date("Y-m-d", strtotime($request->datefrom));
        $dateto = date("Y-m-d", strtotime($request->dateto));

        $search =$request->search;
        $childCount =$request->childCount;
        $roomCount =$request->roomCount;

        if($search != '' && $dateto != "1970-01-01" && $datefrom != "1970-01-01"){
            $hotels = Hotel::where('city','LIKE', "%{$search}%")
                ->orWhere('country','LIKE', "%{$search}%")
                ->orWhere('name','LIKE', "%{$search}%")
                ->orWhere('description','LIKE', "%{$search}%")
                ->orWhereHas('rooms', function ($query) use ($search, $dateto, $datefrom, $roomCount) {
                    $query->where('date_from', '<=',$datefrom)
                        ->where('date_to', '>=', $dateto)
                        ->where('type', 'LIKE', "%{$search}%")
                        ->where('available_rooms', '>=', $roomCount);


                })
                ->orWhereHas('rooms', function ($query) use ($search, $dateto, $datefrom, $roomCount) {
                    $query->where('date_from', '<=',$datefrom)
                        ->where('date_to', '>=', $dateto)
                        ->where('view', 'LIKE', "%{$search}%")
                        ->where('available_rooms', '>=', $roomCount);
                })
                ->orWhereHas('rooms', function ($query) use ($search, $dateto, $datefrom, $roomCount) {
                    $query->where('date_from', '<=',$datefrom)
                        ->where('date_to', '>=', $dateto)
                        ->where('accommodation', 'LIKE', "%{$search}%")
                        ->where('available_rooms', '>=', $roomCount);

                })

                ->get();
        } else if($search != '' && $dateto != "1970-01-01"){
            $hotels = Hotel::where('city','LIKE', "%{$search}%")
                ->orWhere('country','LIKE', "%{$search}%")
                ->orWhere('name','LIKE', "%{$search}%")
                ->orWhere('description','LIKE', "%{$search}%")
                ->orWhereHas('rooms', function ($query) use ($search, $dateto, $datefrom, $roomCount) {
                    $query->where('available_rooms', '>=', $roomCount)
                        ->where('date_to', '>=', $dateto)
                        ->where('type', 'LIKE', "%{$search}%");

                })
                ->orWhereHas('rooms', function ($query) use ($search, $dateto, $datefrom, $roomCount) {
                    $query->where('available_rooms', '>=', $roomCount)
                        ->where('date_to', '>=', $dateto)
                        ->where('view', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('rooms', function ($query) use ($search, $dateto, $datefrom, $roomCount) {
                    $query->where('available_rooms', '>=', $roomCount)
                        ->where('date_to', '>=', $dateto)
                        ->where('accommodation', 'LIKE', "%{$search}%");

                })

                ->get();
        } else if($search != '' && $datefrom != "1970-01-01"){
            $hotels = Hotel::where('city','LIKE', "%{$search}%")
                ->orWhere('country','LIKE', "%{$search}%")
                ->orWhere('name','LIKE', "%{$search}%")
                ->orWhere('description','LIKE', "%{$search}%")
                ->orWhereHas('rooms', function ($query) use ($search, $dateto, $datefrom, $roomCount) {
                    $query->where('date_from', '<=',$datefrom)
                        ->where('available_rooms', '>=', $roomCount)
                        ->where('type', 'LIKE', "%{$search}%");

                })
                ->orWhereHas('rooms', function ($query) use ($search, $dateto, $datefrom, $roomCount) {
                    $query->where('date_from', '<=',$datefrom)
                        ->where('available_rooms', '>=', $roomCount)
                        ->where('view', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('rooms', function ($query) use ($search, $dateto, $datefrom, $roomCount) {
                    $query->where('date_from', '<=',$datefrom)
                        ->where('available_rooms', '>=', $roomCount)
                        ->where('accommodation', 'LIKE', "%{$search}%");

                })

                ->get();
        } else if($search != ''){
            $hotels = Hotel::where('city','LIKE', "%{$search}%")
                ->orWhere('country','LIKE', "%{$search}%")
                ->orWhere('name','LIKE', "%{$search}%")
                ->orWhere('description','LIKE', "%{$search}%")
                ->orWhereHas('rooms', function ($query) use ($search, $dateto, $datefrom, $roomCount) {
                    $query
                        ->where('available_rooms', '>=', $roomCount)
                        ->where('type', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('rooms', function ($query) use ($search, $dateto, $datefrom, $roomCount) {
                    $query
                        ->where('available_rooms', '>=', $roomCount)
                        ->where('view', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('rooms', function ($query) use ($search, $dateto, $datefrom, $roomCount) {
                    $query
                        ->where('available_rooms', '>=', $roomCount)
                        ->where('accommodation', 'LIKE', "%{$search}%");
                })

                ->get();
        } else if($search == '' && $dateto != "1970-01-01" && $datefrom != "1970-01-01"){
            $hotels = Hotel::whereHas('rooms', function ($query) use ($search, $dateto, $datefrom, $roomCount) {
                $query->where('date_from', '<=',$datefrom)
                    ->where('date_to', '>=', $dateto)
                    ->where('available_rooms', '>=', $roomCount);

            })->get();
        }else if($search == '' && $dateto == "1970-01-01" && $datefrom != "1970-01-01"){
            $hotels = Hotel::whereHas('rooms', function ($query) use ($search, $dateto, $datefrom, $roomCount) {
                $query->where('date_from', '<=',$datefrom)
                    ->where('available_rooms', '>=', $roomCount);

            })->get();
        }else if($search == '' && $dateto != "1970-01-01" && $datefrom == "1970-01-01"){
            $hotels = Hotel::whereHas('rooms', function ($query) use ($search, $dateto, $datefrom, $roomCount) {
                $query
                    ->where('date_to', '>=', $dateto)
                    ->where('available_rooms', '>=', $roomCount);

            })->get();
        }else if($search == '' && $dateto == "1970-01-01" && $datefrom == "1970-01-01"){
            $hotels = Hotel::whereHas('rooms', function ($query) use ($search, $dateto, $datefrom, $roomCount) {
                $query
                    ->where('available_rooms', '>=', $roomCount);

            })->get();
        }

//        if($dateto == "1970-01-01" && $datefrom == "1970-01-01"){
//            $hotels = Hotel::where('city','LIKE', "%{$search}%")
//                ->orWhere('country','LIKE', "%{$search}%")
//                ->orWhere('name','LIKE', "%{$search}%")
//                ->orWhere('description','LIKE', "%{$search}%")
//                ->orWhereHas('rooms', function ($query) use ($search, $dateto, $datefrom, $roomCount) {
//                    $query->where('type', 'LIKE', "%{$search}%")
//                        ->where('available_rooms', '>=', $roomCount)
//                        ->orWhere(function($q) use ($search, $roomCount) {
//                        $q->where('view', 'LIKE', "%{$search}%")
//                            ->where('available_rooms', '>=', $roomCount);
//                    })
//                        ->orWhere(function($q2) use ($search, $roomCount) {
//                            $q2->where('accommodation', 'LIKE', "%{$search}%")
//                                ->where('available_rooms', '>=', $roomCount);
//                        });
//
//                })->paginate(6);
//        }
//        $hotels = Hotel::where('city','LIKE', "%{$search}%")
//                ->orWhere('country','LIKE', "%{$search}%")
//                ->orWhere('name','LIKE', "%{$search}%")
//                ->orWhere('description','LIKE', "%{$search}%")
//                ->orWhereHas('rooms', function ($query) use ($search, $dateto, $datefrom, $roomCount) {
//                    $query->where('date_from', '<=',$datefrom)
//                        ->where('date_to', '>=', $dateto)
//                        ->where('type', 'LIKE', "%{$search}%")
//                        ->where('available_rooms', '>=', $roomCount);
//
//                }) ->paginate(6);

        session(['search'=>$search]);
        session(['roomCount'=>$roomCount]);
        session(['dateto'=>$request->dateto]);
        session(['datefrom'=>$request->datefrom]);


        return response(['all_hotels'=>$hotels]);
    }//end of findHotel function

    public function selectRoom($id, $dateto, $datefrom, $childCount, $roomCount)
    {
        $search = session('search');

        $rooms = Room::where('date_from', '<=',$datefrom)
            ->where('date_to', '>=', $dateto)
            -> where('type', 'LIKE', "%{$search}%")
            ->where('available_rooms', '>=', $roomCount)
            ->where('hotel_id', '=', $id)->get();
        if (count($rooms) == 0)
        {
            $rooms = Room::where('date_from', '<=',$datefrom)
                ->where('date_to', '>=', $dateto)
                -> where('view', 'LIKE', "%{$search}%")
                ->where('available_rooms', '>=', $roomCount)
                ->where('hotel_id', '=', $id)->get();
            if (count($rooms) == 0){
                $rooms = Room::where('date_from', '<=',$datefrom)
                    ->where('date_to', '>=', $dateto)
                    ->where('accommodation', 'LIKE', "%{$search}%")
                    ->where('available_rooms', '>=', $roomCount)
                    ->where('hotel_id', '=', $id)->get();
                if(count($rooms) == 0){
                    $errors='Please Select other Check-in and Check-out and check Availability again';
                    return response(['errors'=>$errors , 'search'=>$search]);
                }
            }
        }

        return response(['all_rooms'=>$rooms , 'search'=>$search]);
    }

    //add to cart
    public function addToCart(Request $request)
    {

          Roomcart::create([
                'room_id'=>$request->room_id,
                'checkin'=>$request->date_from,
                'checkout'=>$request->date_to,
                'totalPrice'=>$request->totalPrice,
                'nights'=>$request->nights,
                'roomCount'=>$request->roomCount,
                'childCount'=>$request->childCount,
                'user_id'=>auth()->user()->id,
            ]);
            return response(['success'=> 'Added to cart successfully']);
            //return view('front-end.hotels.room',compact( 'room_id','dateto', 'datefrom', 'id', 'scroll', 'totalPrice', 'avilableNights'));

    }

    public function getCart(string $cartType)
    {
        if ($cartType == 'room'){
            $carts = Roomcart::with('room')->where('user_id', auth()->user()->id)->get();
        }
        else if ($cartType == 'program')
        {
            $carts = ProgramCart::with('trip')->where('user_id', auth()->user()->id)->get();
        }
        return response(['carts'=>$carts , 'type'=>$cartType]);
    }

    public function storeRoomBook(Request $request){

        $validator= Validator::make($request->all(), [
            'firstName'=>['required'],
            'lastName'=>['required'],
            'email'=>['required'],
            'age'=>['required'],
            'phone'=>['required'],
            'travelForWork'=>['required'],
            'bookingFor'=>['required'],
        ]);

        if ($validator->fails()){
            return $this->sendError('error validation', $validator->errors());
        }

        $rooms= Roomcart::where('user_id', auth()->user()->id)->get();
        $book_code= str_random(5);
        foreach ($rooms as $room){
            Booking::create([
                'firstName'=>$request->firstName,
                'lastName'=>$request->lastName,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'gender'=>$request->gender,
                'age'=>$request->age,
                'country'=>$request->country,
                'specialRequest'=>$request->specialRequest,
                'travelForWork'=>$request->travelForWork[0],
                'bookingFor'=>$request->bookingFor[0],
                'otherPersonName'=>$request->otherPersonName,
                'otherPersonPhone'=>$request->otherPersonPhone,
                'price'=>$room->totalPrice,
                'checkin'=>$room->checkin,
                'checkout'=>$room->checkout,
                'childCount'=>$room->childCount,
                'roomCount'=>$room->roomCount,
                'room_id'=>$room->room_id,
                'user_id'=>auth()->user()->id,
                'book_code'=>$book_code,
            ]);
            $room->delete();

        }

        $success['book_code']= $book_code;

        return $this->sendResponse($success, 'Reservation Created Successfully');
    }

    public function roomCart($room_id, $checkin, $checkout, $totalPrice, $nights)
    {

        Roomcart::create([
            'room_id'=>$room_id,
            'checkin'=>$checkin,
            'checkout'=>$checkout,
            'totalPrice'=>$totalPrice,
            'nights'=>$nights,
            'user_id'=>auth()->user()->id,
        ]);

        session()->flash('success', __('site.addedToCart_successfully'));
        return redirect()->back();
    }
}
