<?php

namespace App\Http\Controllers\BackEnd;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UsersController extends BackEndController
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {
        $rows = $this->model;
        $rows = $this->filter($rows);
        $rows = $rows->where('group', '!=', 'admin')->paginate(5);

        $module_name_plural=$this->getClassNameFromModel();
        $module_name_singular=$this->getSingularModelName();

        return view('back-end.'.$this->getClassNameFromModel().'.index', compact('rows', 'module_name_singular', 'module_name_plural'));

    }

  /*  protected function filter($rows){

        if(request()->has('name') && request()->get('name') != ''){

            $rows = $rows->where('name', request()->get('name'));
        }
        return $rows;
    }*/

    public function store(Request $request)
    {
        $request->validate([
            'firstName' => ['required', 'string', 'max:191'],
            'lastName' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],

        ]);
        $request_data=$request->except(['image', 'password','api_token']);

        // store image
        if ($request->image){

            $this->uploadImage($request);

            $request_data['image'] = $request->image->hashName();
        } //end of if

        $request_data['password']= Hash::make($request->password);
        $request_data['api_token']=hash('md5','user');
        User::create($request_data);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('users.index');
    } //end of store

    public function update(Request $request, User $user)
    {
        $request->validate([
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['confirmed'],
        ]);

        $request_data=$request->except(['password', 'image']);

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
        return redirect()->route('users.index');

    }//end of update

    protected function uploadImage($request){

        \Intervention\Image\Facades\Image::make($request->image)->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('uploads/user_images/'. $request->image->hashName()));
    }

}
