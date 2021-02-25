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
        $user = User::find(auth()->user()->id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastName' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id),],
            'password' => ['nullable', 'min:5'],
            'c_password' => ['nullable', 'same:password'],
            'gender' => ['nullable', Rule::in([0, 1])],
            'phone' => ['required', 'size:11', Rule::unique('users')->ignore($user->id),],
            'ssn' => ['nullable', 'size:14', Rule::unique('users')->ignore($user->id),],
            'adress' => ['required', 'string', 'max:255'],
            'area_id' => ['required', 'exists:areas,id'],
            'image' => ['nullable', 'image'],
        ]);
        $request_date = $request->except(['image', 'c_password', '_token',]);
        if ($request->image) {
            if ($user->image != 'user.png') {
                Storage::disk('public_uploads')->delete('/users_images/' . $user->image);
            }
            $this->uploadImage($request);
            $request_date['image'] = $request->image->hashName();
        }
        $request_date['password'] = bcrypt( $request->password );

        $updateUser = $user->update($request_date);

        if ($updateUser)
            return $this->sendResponse($request_date, 'updated sucesffuly', 200);
        else
            return $this->sendError('no updata', ['data' => $user,], 200);
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
        $img = \Intervention\Image\Facades\Image::make($request->image)->resize(912, 872);

        $img->save(public_path('uploads/users_images/' . $request->image->hashName()));

    }
}
