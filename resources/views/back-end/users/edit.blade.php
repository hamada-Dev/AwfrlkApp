@extends('back-end.layout.app')

@php
    $group = (isset($row) && $row->group == 'delivery') ? __('site.delivery') : ((isset($row) && $row->group == 'emp') ? __('site.emp') : __('site.user') ) 
@endphp
@section('title')
    {{$group}}
@endsection

@section('content')

    @component('back-end.layout.nav-bar')

        @slot('nav_title')
           {{ $group}}
        @endslot

    @endcomponent

    <div class="col-md-8">

        {{--card--}}
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">@lang('site.edit') {{$group}} </h4>
                <p class="card-category">@lang('site.edit_desc')</p>
            </div>

            {{--card body--}}
            <div class="card-body">

                <form action="{{route($module_name_plural.'.update', $row->id)}}" method="post" enctype="multipart/form-data">
                    {{method_field('PUT')}}
                    @include('back-end.'.$module_name_plural.'.form')
                    <button type="submit" class="btn btn-primary pull-right">@lang('site.edit') {{$group}}</button>
                    <div class="clearfix"></div>

                </form> {{--end of form--}}

            </div> {{--end of card body--}}

        </div> {{--end of card--}}

    </div> {{--end of colum 8--}}

@endsection

