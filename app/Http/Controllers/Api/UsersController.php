<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    public function login(Request $request){

       $rules=[
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required']
        ];
       $validate =Validator::make($request->all(), $rules);

       if ($validate->fails()){
         return response(['status'=>false, 'message'=>$validate->messages()]);
       }
       else
       {
           if(auth()->attempt(['email'=> $request->email, 'password'=> $request->password] )){
               $user=auth()->user();
               $user->api_token= str_random(60);
               $user->save();
               return response(['status'=>true, 'user'=>$user, 'token'=>$user->api_token]);
           }
           else{
               return response(['status'=>false, 'message'=>'email or password incorrect']);
           }

       }
    }//end of login
}
