<?php

namespace App\Http\Controllers\BackEnd;

use App\Models\User;
use App\Models\Usersalary;

use App\Models\DeliveryStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;


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
        $rows = $rows->employee()->where('delivery_status', '<>', 3)->latest()->paginate(PAG_COUNT);

        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // start for who take money
        $month_start = strtotime('first day of this month', time());
        $month_end = strtotime('last day of this month', time());
        $firstDayMonth = date('Y-m-d', $month_start) . ' 00:00:00';
        $lastDayMonth = date('Y-m-d', $month_end) . ' 23:59:59';
        $whotakemoney = Usersalary::where('moneyDay', '>=', $firstDayMonth)
            ->where('moneyDay', '<=', $lastDayMonth)->pluck('user_id')->toArray();
        // end for who take the money
        return view('back-end.' . $this->getClassNameFromModel() . '.index', compact('whotakemoney', 'rows', 'module_name_singular', 'module_name_plural'));
    }

    /*  protected function filter($rows){

        if(request()->has('name') && request()->get('name') != ''){

            $rows = $rows->where('name', request()->get('name'));
        }
        return $rows;
    }*/


    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'lastName'  => ['required', 'string', 'max:255'],
            'email'     => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['nullable', 'min:5'],
            'c_password' => ['nullable', 'same:password'],
            'gender'    => ['required', Rule::in([0, 1])],
            'phone'     => ['required', 'regex:/(01)[0-9]{9}/', 'unique:users'],
            'group'     => ['required', Rule::in(['admin', 'emp', 'delivery', 'user'])],
            'ssn'       => ['required', 'regex:/[0-9]{14}/', 'unique:users'],
            'adress'    => ['required', 'string', 'max:255'],
            'area_id'   => ['required', 'exists:areas,id'],
            'image'     => ['image'],
            'delivery_status' => ['required', Rule::in([0, 1, 2, 3, 4])],
        ]);

        $request_data = $request->except(['image', 'password', 'c_password', 'api_token']);

        // store image
        if ($request->image) {

            $this->uploadImage($request);

            $request_data['image'] = $request->image->hashName();
        } //end of if

        $request_data['password'] = $request->password == null ?  Hash::make(12345) : Hash::make($request->password);
        $request_data['api_token'] = hash('md5', 'user');
        $request['added_by'] = auth()->user()->id;

        $newUser = User::create($request_data);
        if ($request->group == 'delivery') {
            $newUser->deliveryStatus()->create([
                'status'   => 1,
            ]);
            return redirect()->route('deliverymotocycles.create', ['dID' => $newUser->id]);
        } else {
            return redirect()->route('users.index');
        }
    } //end of store

    public function update(Request $request, User $user)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'min:5'],
            'c_password' => ['nullable', 'same:password'],
            'gender' => ['required', Rule::in([0, 1])],
            'phone' => ['required', 'regex:/(01)[0-9]{9}/', Rule::unique('users')->ignore($user->id)],
            'group' => ['required', Rule::in(['admin', 'emp', 'delivery', 'user'])],
            'ssn' => ['required', 'regex:/[0-9]{14}/', Rule::unique('users')->ignore($user->id)],
            'adress' => ['required', 'string', 'max:255'],
            'area_id' => ['required', 'exists:areas,id'],
            'image'     => ['image'],
            'delivery_status' => ['required', Rule::in([0, 1, 2, 3, 4])],
        ]);

        $request_data = $request->except(['password', 'image', 'c_password']);

        // store image
        if ($request->image) {

            if ($user->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/user_images/' . $user->image);
            }

            $this->uploadImage($request);

            $request_data['image'] = $request->image->hashName();
        } //end of if

        $request_data['password'] = $request->password == null ?  Hash::make(12345) : Hash::make($request->password);

        // check for update price to add it in productUpdate

        $user->update($request_data);

        session()->flash('success', __('site.updated_successfully'));
        if ($request->group == 'delivery')
            return redirect()->route('users.delivery');
        elseif ($request->group == 'user')
            return redirect()->route('users.usersShow');
        else
            return redirect()->route('users.index');
    } //end of update

    public function destroy($id, Request $request)
    {


        $userdeleted = User::findOrFail($id);

   
        try {
            DB::beginTransaction();
            $userdeleted->deleted_by   = auth()->user()->id;
            $userdeleted->delete_date  = now();
            $userdeleted->save();
            $userdeleted->ordersUser()->update([ // if user update order
                'deleted_by'   => auth()->user()->id,
                'delete_date'  => now(),
            ]);
            $userdeleted->deliveryMoto()->update([ // if delivery update motosycle
                'deleted_by'   => auth()->user()->id,
                'delete_date'  => now(),
            ]);
            $userdeleted->AauthAcessToken()->delete(); // if user login from app will logout
            DB::commit();
            session()->flash('error', __('site.deleted_successfully'));
        } catch (\Exception $ex) {
            DB::rollBack();
            session()->flash('error', __('site.action_error'));
        }

        return redirect()->back();
        // return redirect()->route($this->getClassNameFromModel() . '.index');
    }

    protected function uploadImage($request)
    {
        $img = \Intervention\Image\Facades\Image::make($request->image)->resize(912, 872);

        $img->save(public_path('uploads/users_images/' . $request->image->hashName()));
    }

    public function showDelivery()
    {
        $rows = $this->model;
        $rows = $this->filter($rows);

        $rows = $rows->where('group', 'delivery')->where('delivery_status', '<>', 3)->latest()->paginate(PAG_COUNT);

        // start for who take money
        $month_start = strtotime('first day of this month', time());
        $month_end = strtotime('last day of this month', time());
        $firstDayMonth = date('Y-m-d', $month_start) . ' 00:00:00';
        $lastDayMonth = date('Y-m-d', $month_end) . ' 23:59:59';
        $whotakemoney = Usersalary::where('moneyDay', '>=', $firstDayMonth)
            ->where('moneyDay', '<=', $lastDayMonth)->pluck('user_id')->toArray();
        // end for who take the money
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        return view('back-end.' . $this->getClassNameFromModel() . '.showdelivery', compact('whotakemoney', 'rows', 'module_name_singular', 'module_name_plural'));
    }
    public function showUser()
    {
        $rows = $this->model;
        $rows = $this->filter($rows);

        $rows = $rows->where('group', 'user')->where('delivery_status', '<>', 3)->latest()->paginate(PAG_COUNT);

        // start for who take money
        $month_start = strtotime('first day of this month', time());
        $month_end = strtotime('last day of this month', time());
        $firstDayMonth = date('Y-m-d', $month_start) . ' 00:00:00';
        $lastDayMonth = date('Y-m-d', $month_end) . ' 23:59:59';
        $whotakemoney = Usersalary::where('moneyDay', '>=', $firstDayMonth)
            ->where('moneyDay', '<=', $lastDayMonth)->pluck('user_id')->toArray();
        // end for who take the money
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        return view('back-end.' . $this->getClassNameFromModel() . '.showUsers', compact('whotakemoney', 'rows', 'module_name_singular', 'module_name_plural'));
    }


    public function statusDelivery($delivery_id)
    {
        $rows = $this->model->find($delivery_id);
        $rows = $rows->deliveryStatus;
        // return $rows;
        return view('back-end.' . $this->getClassNameFromModel() . '.deliverystatus', compact('rows'));
    }


    public function addBlacklist($id)
    {
        $row = $this->model->find($id);
        if ($row->delivery_status != 3) {
            $row->delivery_status = 3;
        } elseif ($row->group == "user" || $row->group == "emp" || $row->group == "admin") {
            $row->delivery_status = 4;
        } else {
            $row->delivery_status = 1;
        }
        $row->save();

        session()->flash('success', __('site.updated_successfully'));
        if ($row->group == "delivery")
            return redirect()->back();
        else
            return redirect()->back();
    }



    public function showBlacklist()
    {
        $rows = $this->model;
        $rows = $this->filter($rows);
        $rows = $rows->where('delivery_status', '3')->latest()->paginate(PAG_COUNT);

        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        return view('back-end.' . $this->getClassNameFromModel() . '.blacklist', compact('rows', 'module_name_singular', 'module_name_plural'));
    }
}
