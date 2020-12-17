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
                <h4 class="card-title">@lang('site.add') @lang('site.'.$module_name_singular)</h4>
                <p class="card-category">@lang('site.edit_desc')</p>
            </div>

            {{--card body--}}
            <div class="card-body">

                    @include('back-end.'.$module_name_plural.'.form')
                    <div class="clearfix"></div>

            </div> {{--end of card body--}}

        </div> {{--end of card--}}

    </div> {{--end of colum 8--}}

@endsection

