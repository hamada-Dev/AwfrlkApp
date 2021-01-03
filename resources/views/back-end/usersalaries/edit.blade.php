@extends('back-end.layout.app')

@php

@endphp
@section('title')
    @lang('site.'.$module_name_plural)
@endsection

@section('content')

    @component('back-end.layout.nav-bar')

        @slot('nav_title')
            @lang('site.'.$module_name_plural)
        @endslot

    @endcomponent

    <div class="col-md-8">

        {{--card--}}
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">@lang('site.edit') @lang('site.'.$module_name_singular)</h4>
                <p class="card-category">@lang('site.edit_desc')</p>
            </div>

            {{--card body--}}
            <div class="card-body">

                <form action="{{route($module_name_plural.'.update', $row->id)}}" method="post" enctype="multipart/form-data">
                    {{method_field('PUT')}}
                    @include('back-end.'.$module_name_plural.'.form')
                    <button type="submit" class="btn btn-primary pull-right">@lang('site.edit') @lang('site.'.$module_name_singular)</button>
                    <div class="clearfix"></div>

                </form> {{--end of form--}}

            </div> {{--end of card body--}}

        </div> {{--end of card--}}

    </div> {{--end of colum 8--}}

@endsection

