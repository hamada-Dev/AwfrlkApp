<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use App\Models\Program;
use App\Models\ProgramCart;
use App\Models\Roomcart;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfilesController extends BaseController
{
    public function profile($id, $slug =null){

        $user=User::findOrFail($id);
        $rooms =Roomcart::where('user_id', $id)->get();
        $programs = ProgramCart::where('user_id', $id)->get();

        return view('front-end.profiles.index', compact('user', 'rooms','programs'));
    } //end of profile

    public function bookings($id){

        $user=User::findOrFail($id);
        $rooms =Booking::where('user_id', $id)->get();
        $programs = Program::where('user_id', $id)->get();

        return view('front-end.profiles.bookingInfo', compact('user', 'rooms','programs'));
    } //end of profile

    public function bookingsInfo(Request $request){

        $request->validate([
            'code' => ['required'],
            ]);

        $rooms =Booking::with('room')->where('book_code', $request->code)->get();
        $programs = Program::with('trip')->where('book_code', $request->code)->get();

        return response(['Rooms'=>$rooms, 'Programs'=> $programs]);
    } //end of profile

    public function userBookings(){

        $rooms =Booking::with('room')->where('user_id', auth()->user()->id)->get();
        $programs = Program::with('trip')->where('user_id', auth()->user()->id)->get();

        return response(['Rooms'=>$rooms, 'Programs'=> $programs]);
    } //end of userBookings

    public function destroyRoom($id)
    {
        $room=Roomcart::findOrFail($id);
        $room->delete();
        return response()->json('Deleted Successfully', 200);

    }

    public function destroyProgram($id)
    {
        $room=ProgramCart::findOrFail($id);
        $room->delete();
        return response()->json('Deleted Successfully', 200);

    } //end of destroyProgram

    public function update($id, $slug=null, Request $request){

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'password' => ['confirmed'],
        ]);

        $user=User::findOrFail($id);
        $request_data=$request->except(['password' , 'image']);
        // store image
        if ($request->image){

            if($user->image != 'default.png'){
                Storage::disk('public_uploads')->delete('/user_images/'. $user->image);
            }

            $this->uploadImage($request);

            $request_data['image'] = $request->image->hashName();
        } //end of if


        if($request->has('password') && $request->get('password') != ''){

            $request_data += ['password' => Hash::make($request->password)];
        }

        $user->update($request_data);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('front.profile', ['id'=>$id]);
    }

    protected function uploadImage($request){

        \Intervention\Image\Facades\Image::make($request->image)->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('uploads/user_images/'. $request->image->hashName()));
    }

    public function cart($id){

        $user=User::findOrFail($id);
        $carts =Roomcart::where('user_id', $id)->get();
        $programs = ProgramCart::where('user_id', $id)->get();
        dd($carts);
        return view('front-end.cart.index', compact('user', 'carts','programs'));
    } //end of profile

    public function messageStore( Request $request){
        $validator= Validator::make($request->all(), [
            'name'=>['required', 'string'],
            'email'=>['required','email'],
            'message'=>['required', 'min:5', 'max:191'],
        ]);

        if ($validator->fails()){
            return $this->sendError('error validation', $validator->errors());
        }
        $data =Message::create($request->all());
        return $this->sendResponse($data, 'Message Sent Successfully');
    }//end of message store

}
