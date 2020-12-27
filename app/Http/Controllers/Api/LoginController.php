<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public $successStatus = 200;

    public function login()
    {
        if (Auth::attempt(['phone' => request('username'), 'password' => request('password')])) {
            $user = Auth::user();
            $user->AauthAcessToken()->delete();
            Auth::logoutOtherDevices(request('password'));
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success, 'type' => auth()->user()->group ], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
