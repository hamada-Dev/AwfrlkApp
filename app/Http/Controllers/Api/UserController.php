<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id', auth()->user()->id)->get();
        if ($user->count() > 0)
            return $this->sendResponse(UserResource::collection($user), 200);
        else
            return $this->sendError('no user with this id ', ['data' => 'no data ',], 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $user = User::where('id', $id)->get();

        $request->validate([
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id),],
            'password' => ['required', 'min:5'],
            'c_password' => ['required', 'same:password'],
            'gender' => ['nullable', Rule::in([0, 1])],
            'phone' => ['required', 'size:11', Rule::unique('users')->ignore($id),],
            'ssn' => ['nullable', 'size:14', Rule::unique('users')->ignore($id),],
            'adress' => ['required', 'string', 'max:255'],
            'area_id' => ['nullable', 'exists:areas,id'],
        ]);
        $request_date = $request->except(['image', 'c_password', '_token',]);
        if ($request->image) {
            if ($user->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/users_images/' . $user->image);
            }
            $this->uploadImage($request);
            $request_date['image'] = $request->image->hashName();
        }

        $updateUser = $user->update($request_date);

        if ($updateUser)
            return $this->sendResponse($request_date, 'updated sucesffuly');
        else
            return $this->sendError('no updata', ['data' => $user,], 404);
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

    protected function uploadImage($request)
    {
        \Intervention\Image\Facades\Image::make($request->image)->save(public_path('uploads/users_images/' . $request->image->hashName()));
        //            ->resize(300, null, function ($constraint) {
        //            $constraint->aspectRatio();

    }
}
