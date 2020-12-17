<?php

namespace App\Http\Controllers\Api;

use App\Models\Program;
use App\Models\ProgramCart;
use App\Models\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TripsController extends BaseController
{
    public function category($id)
    {
        $rows = Trip::with('complimentaries')->where('category_id', $id)->get();
        return response()->json($rows,200);
    }

    public function showTrip($id)
    {
        $row = Trip::findOrFail($id);
        return response(['program'=>$row]);
    }

    public function price(Request $request)
    {
        if($request->get('query')) {
            $query = $request->get('query');
            $id= $request->get('id');
            $price = 'price'.$query;
            $price = Trip::where('id',$id)->pluck($price)->first();

            $output = '<p  id="totalPrice" value="'.$price.'" >Price Per One Person: <b>$'.$price.'</b></p>';
            $output .= '<input type="hidden" value="'.$price.'" name="totalPrice">';
            echo $output;
        }
    }

    public function addToCart(Request $request)
    {
        $validator= Validator::make($request->all(), [
            'persons'=>['required','integer'],
            'totalPrice'=>['required','integer']
        ]);
        if ($validator->fails()){
            return $this->sendError('error validation', $validator->errors());
        }


        $data = ProgramCart::create([
            'user_id'=>auth()->user()->id,
            'trip_id'=>$request->tripId,
            'persons'=>$request->persons,
            'totalPrice'=>$request->totalPrice,
        ]);

        return $this->sendResponse($data, 'Added To cart Successfully');

//        $price = 'price'.$request->persons;
//        $price = Trip::where('id',$request->tripId)->pluck($price)->first();

    }

    public function programBook(Request $request){

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


        $programs= ProgramCart::where('user_id', auth()->user()->id)->get();
        $book_code= str_random(5);
        foreach ($programs as $program){
            Program::create([
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
                'price'=>$program->totalPrice,
                'persons'=>$program->persons,
                'trip_id'=>$program->trip_id,
                'user_id'=>$program->user_id,
                'book_code'=>$book_code,
            ]);
            $program->delete();

        }

        $success['book_code']= $book_code;

        return $this->sendResponse($success, 'Reservation Created Successfully');
    }// end of programBook function

    public function findTrip( Request $request)
    {

        $search =$request->search;
        $days =$request->days;
        if ($search !='')
        {
            $rows= Trip::where('cities','LIKE', "%{$search}%")
                ->orWhere('trip_caption','LIKE', "%{$search}%")
                ->orWhere('title','LIKE', "%{$search}%")
                ->orWhere('trip_code','LIKE', "%{$search}%")
                ->orWhere('overview','LIKE', "%{$search}%")
                ->orWhere('includes','LIKE', "%{$search}%")
                ->orWhere('excludes','LIKE', "%{$search}%")
                ->where('days',$days)
                ->get();


        }else
        {
            $rows= Trip::where('days',$days)
                ->get();
        }


        return response()->json($rows,200);
    }//end of findProgram function


}
