@extends('back-end.layout.app')

@section('title')
@lang('site.home')
@endsection

@section('content')

@component('back-end.layout.nav-bar')

@slot('nav_title')
@lang('site.home')
@endslot

@endcomponent
{{-- <style>
 .dark-edition .card{
     background: #e63946 !import;
 }
    .dark-edition .card{
        background:radial-gradient(red, transparent)
    }
</style> --}}
<div class="row">




    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <a href="{{route('pending.index', ['process'  => 1])}}">
                    <div class="card-icon">
                        <i class="material-icons">-person-</i>
                    </div>
                </a>
                <h2 class="card-category" style='color:#f87e08; font-size: 22px;text-align:center;'>@lang('site.orderWait')</h2>
                <h3 class="card-title text-center" style='color:red'>
                    {{App\Models\Order::whereNull('delivery_id')->where('status', 0)->count()}}
                </h3>
            </div>
        </div>
    </div>


    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <a href="{{route('pending.index', ['delivery'  => 1])}}">
                    <div class="card-icon">
                        <i class="material-icons">-person-</i>
                    </div>
                </a>
                <h2 class="card-category" style='color:#f87e08; font-size: 22px;text-align:center;'>@lang('site.orderDelivery')</h2>
                <h3 class="card-title text-center" style='color:red'>
                    {{App\Models\Order::whereNotNull('delivery_id')->where('status', 0)->whereNull('end_shoping_date')->count()}}
                </h3>
            </div>
        </div>
    </div>


    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <a href="{{route('pending.index', ['road'  => 1])}}">
                    <div class="card-icon">
                        <i class="material-icons">-person-</i>
                    </div>
                </a>
                <h2 class="card-category" style='color:#f87e08; font-size: 22px;text-align:center;'>@lang('site.orderRoad')</h2>
                <h3 class="card-title text-center" style='color:red'>
                    {{App\Models\Order::whereNotNull('delivery_id')->where('status', 0)->whereNotNull('end_shoping_date')->count()}}
                </h3>
            </div>
        </div>
    </div>







    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <a href="{{route('users.delivery')}}">
                    <div class="card-icon">
                        <i class="material-icons">-person-</i>
                    </div>
                </a>
                <h2 class="card-category" style='color:#f87e08; font-size: 22px;text-align:center;'>@lang('site.delivery')</h2>
                <h3 class="card-title text-center" style='color:red'>
                    {{App\Models\User::where('group','delivery')->count()}}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <a href="{{route('users.delivery')}}">
                    <a href="{{route('users.index')}}">
                        <div class="card-icon">
                            <i class="material-icons">-person-</i>
                        </div>
                    </a>
                    <h2 class="card-category" style='color:#f87e08; font-size: 22px;text-align:center;'>@lang('site.users')</h2>
                    <h3 class="card-title text-center" style='color:red'>
                        {{App\Models\User::where('group',' emp')->count()}}
                    </h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <a href="{{route('users.usersShow')}}">
                    <div class="card-icon">
                        <i class="material-icons">-person-</i>
                    </div>
                </a>
                <h2 class="card-category" style='color:#f87e08; font-size: 22px;text-align:center;'>@lang('site.usersShow')</h2>
                <h3 class="card-title text-center" style='color:red'>
                    {{App\Models\User::where('group','user')->count()}}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <a href="{{route('categories.index')}}">
                    <div class="card-icon">
                        <i class="material-icons">-category-</i>
                    </div>
                </a>
                <h2 class="card-category" style='color:#f87e08; font-size: 22px;text-align:center;'>@lang('site.categories')</h2>
                <h3 class="card-title text-center" style='color:red'>
                    {{App\Models\Category::all()->count()}}
                </h3>
            </div>

        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <a href="{{route('products.index')}}">
                    <div class="card-icon">
                        <i class="material-icons">-cake-</i>
                    </div>
                </a>
                <h2 class="card-category" style='color:#f87e08; font-size: 22px;text-align:center;'>@lang('site.products')</h2>
                <h3 class="card-title text-center" style='color:red'>
                    {{App\Models\Product::all()->count()}}
                </h3>
            </div>

        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <a href="{{route('offers.index')}}">

                    <div class="card-icon">
                        <i class="material-icons">-local_offer-</i>
                    </div>
                </a>
                <h2 class="card-category" style='color:#f87e08; font-size: 22px;text-align:center;'>@lang('site.offers')</h2>
                <h3 class="card-title text-center" style='color:red'>
                    {{App\Models\Offer::where('avilable',1)->count()}}
                </h3>
            </div>

        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <a href="{{route('promocodes.index')}}">

                    <div class="card-icon">
                        <i class="material-icons">-local_offer-</i>
                    </div>
                </a>
                <h2 class="card-category" style='color:#f87e08; font-size: 22px; text-align:center;'>@lang('site.promocodes')</h2>
                <h3 class="card-title text-center" style='color:red'>
                    {{App\Models\Promocode::where('confirm',1)->count()}}
                </h3>
            </div>

        </div>
    </div>


    <!-- <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                {{-- <h4 style="display:inline-block;" class="card-title">@lang('site.comments') <sub>[ {{count($comments)}} ]</sub></h4> --}}
                <p class="card-category">Latest Comments</p>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <thead class="text-warning">
                    <tr><th>ID</th>
                        <th>@lang('site.name')</th>
                        <th>@lang('site.video')</th>
                        <th>@lang('site.comment')</th>
                        <th>@lang('site.date')</th>
                    </tr></thead>
                    <tbody>
                    {{-- @foreach($comments as $index=>$comment)
                    <tr>
                        <td>{{++$index}}</td>
                        <td><a href="{{route('users.edit', $comment->user->id)}}">{{$comment->user->name}}</a> </td>
                        <td>{{$comment->comment}}</td>
                        <td>{{$comment->created_at}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $comments->links() !!} --}}
            </div>
        </div>
    </div> -->

    @endsection