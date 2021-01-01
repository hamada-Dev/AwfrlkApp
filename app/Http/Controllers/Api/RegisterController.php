<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends BaseController
{

    public $successStatus = 200;

    public function register(Request $request)
    {
        // if (auth()->user()) {
        //     return User::where('id', auth()->user()->id)->get();
        //     return new UserResource(User::where('id', auth()->user()->id)->get());
        // }


        $validator = Validator::make($request->all(), [
            'firstName' => ['required', 'string', 'max:255'],
            // 'lastName' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:5'],
            'c_password' => ['required', 'same:password'],
            // 'gender' => ['required', Rule::in([0, 1])],
            'phone' => ['required', 'unique:users', 'size:11'],
            // 'ssn' => ['required', 'unique:users', 'size:14'],
            'adress' => ['required', 'string', 'max:255'],
            'area_id' => ['nullable', 'exists:areas,id'],
            // 'image' => ['nullable', 'image'],
        ]);
        if ($validator->fails()) {
            return $this->sendError('error validation', $validator->errors());
        }
        // return $request;

        if ($request->image) {
            $this->uploadImage($request);
            $image = $request->image->hashName();
        } else {
            $image = "default.png";
        }

        $user = User::create([
            'name' => $request['firstName'],
            // 'lastName' => $request['lastName'],
            // 'email' => $request['email'],
            'password' => bcrypt($request['password']),
            // 'password' => Hash::make($request['password']),
            // 'gender' => $request['gender'],
            'phone' => $request['phone'],
            // 'ssn' => $request['ssn'],
            'adress' => $request['adress'],
            'area_id' => $request['area_id'],
            'api_token' => '',
            // 'image' => $image,
        ]);

        // $user->sendApiEmailVerificationNotification();
        $success['message'] = 'Please confirm email by clicking on verify user button sent to you on your email';
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name . ' ' . $user->lastName;

        return $this->sendResponse($success, 'User Created Successfully');
    } // end of register function

    public function logoutApi()
    {
        if (Auth::check()) {
            Auth::user()->AauthAcessToken()->delete();
            // Auth::user()->token()->revoke();
            return $this->sendResponse(' you are logged out successfully', 200);
        }
    } //end of logout Api

    public function details()
    {
        $user = Auth::user();
        return response()->json(['User' => $user], $this->successStatus);
    }

    protected function uploadImage($request)
    {
        \Intervention\Image\Facades\Image::make($request->image)->save(public_path('uploads/users_images/' . $request->image->hashName()));
        //            ->resize(300, null, function ($constraint) {
        //            $constraint->aspectRatio();

    }
}
