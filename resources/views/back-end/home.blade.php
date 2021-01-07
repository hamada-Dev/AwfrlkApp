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

    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                    <a href="{{route('users.delivery')}}">
                        <div class="card-icon">
                            <i class="material-icons">-person-</i>
                        </div>
                    </a>
                    <h2 class="card-category" style='color:black;text-align:center;'>@lang('site.delivery')</h2>
                    <h3 class="card-title text-center" style='color:black'>
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
                    <h2 class="card-category" style='color:black;text-align:center;'>@lang('site.users')</h2>
                    <h3 class="card-title text-center" style='color:black'>
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
                    <h2 class="card-category" style='color:black;text-align:center;'>@lang('site.usersShow')</h2>
                    <h3 class="card-title text-center" style='color:black'>
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
                    <h2 class="card-category" style='color:black;text-align:center;'>@lang('site.categories')</h2>
                    <h3 class="card-title text-center" style='color:black'>
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
                    <h2 class="card-category" style='color:black;text-align:center;'>@lang('site.products')</h2>
                    <h3 class="card-title text-center" style='color:black'>
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
                    <h2 class="card-category" style='color:black;text-align:center;'>@lang('site.offers')</h2>
                    <h3 class="card-title text-center" style='color:black'>
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
                    <h2 class="card-category" style='color:black;text-align:center;'>@lang('site.promocodes')</h2>
                    <h3 class="card-title text-center" style='color:black'>
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

