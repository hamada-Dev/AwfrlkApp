<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends BaseController
{

    public $successStatus = 200;

    public function register(Request $request){
        $validator= Validator::make($request->all(), [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:5'],
            'c_password' => ['required', 'same:password'],
            'gender' => ['required', Rule::in([0, 1])],
            'phone' => ['required', 'unique:users'],
            'ssn' => ['required', 'integer', 'unique:users'],
            'adress' => ['required', 'string', 'max:255'],
            'area_id' => ['nullable', 'exists:area,id'],
        ]);

        if ($validator->fails()){
            return $this->sendError('error validation', $validator->errors());
        }

        $user= User::create([
            'firstName' => $request['firstName'],
            'lastName' => $request['lastName'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'gender' => $request['gender'],
            'phone' => $request['phone'],
            'ssn' => $request['ssn'],
            'adress' => $request['adress'],
            'area_id' => $request['area_id'],
            'api_token' => '',
        ]);
           
        // $user->sendApiEmailVerificationNotification();
        $success['message'] = 'Please confirm email by clicking on verify user button sent to you on your email';
        $success['token']= $user->createToken('MyApp')->accessToken;
        $success['name']= $user->firstName. ' '. $user->lastName;

        return $this->sendResponse($success, 'User Created Successfully');
    } // end of register function

    public function logoutApi()
    {
        if (Auth::check()) {
            // Auth::user()->AauthAcessToken()->delete();
            Auth::user()->token()->revoke();
        }
    }//end of logout Api

    public function details()
    {
    $user = Auth::user();
    return response()->json(['User' => $user], $this-> successStatus);
    }

}
