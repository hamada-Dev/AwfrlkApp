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
                    <div class="card-icon">
                        <i class="material-icons">-tv-</i>
                    </div>
                    <h2 class="card-category">@lang('site.bookings')</h2>
                    <h3 class="card-title">
                        {{App\Models\User::Employee()->count()}}
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons text-warning">tv</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">bubble_chart</i>
                    </div>
                    <h2 class="card-category">@lang('site.hotels')</h2>
                    <h3 class="card-title">
                        {{App\Models\User::Admin()->count()}}
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">date_range</i> Last 24 Hours
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">local_offer</i>
                    </div>
                    <p class="card-category">@lang('site.rooms')</p>
                    <h3 class="card-title">
                        {{App\Models\User::Delivery()->count()}}
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">local_offer</i> Tracked from Videos
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <p class="card-category">@lang('site.users')</p>
                    <h3 class="card-title">
                        {{-- {{App\Models\User::count()}} --}}
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">update</i> Just Updated
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12">
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
    </div>

@endsection

