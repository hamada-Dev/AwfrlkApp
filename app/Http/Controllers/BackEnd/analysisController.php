<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Scopes\NonDeleteIScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class analysisController extends Controller
{
    public function index(Request $request)
    {       
        return User::user()->get();

         $user =  User::user()->with(['ordersUser' => function($query){
             return $query ->select('client_id', DB::raw("count(*) as total11 "))->groupBy('client_id')
                ->withOutGlobalScope(NonDeleteIScope::class)->get();
         }])->withOutGlobalScope(NonDeleteIScope::class)->get();
        return $user;
        $orders = DB::table('orders')
            ->select('client_id', DB::raw("count(*) as total "))
            ->groupBy('client_id')->get();
        return $orders;
        return view('back-end.analysis.index');
    }
}
