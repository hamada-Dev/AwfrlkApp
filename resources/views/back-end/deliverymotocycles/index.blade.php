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

@component('back-end.partial.table', ['module_name_plural'=>$module_name_plural ,
'module_name_singular'=>$module_name_singular])
@slot('add_button')
<div class="col-md-4 text-right">
    <a href="{{route($module_name_plural.'.create', request() != NULL ? ['category_id'=> request()->category_id] : ''  ) }}" class="btn btn-white btn-round ">
        @lang('site.add') @lang('site.'.$module_name_singular)
    </a>
</div>
@endslot

<div class="table-responsive">
    <table  id="dataTable"  id="dataTable" class="table">
        <thead class=" text-primary">
            <tr>
      
                <th>
                    @lang('site.id')
                </th>
                <th>
                    @lang('site.user_license')
                </th>
                <th>
                    @lang('site.moto_license')
                </th>
                {{-- <th>
                    @lang('site.moto_number')
                </th> --}}
                <th>
                    @lang('site.license_renew_date')
                </th>
                <th>
                    @lang('site.license_expire_date')
                </th>
                {{-- <th>
                    @lang('site.type')
                </th>
                <th>
                    @lang('site.color')
                </th> --}}
                <th>
                    @lang('site.user_id')
                </th>
                <th class="text-right">
                    @lang('site.actions')
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach($rows as $row)

            <tr>
                <td>
                    {{$row->id}}
                </td>

                <td>
                    {{$row->user_license}}
                </td>
                <td>
                    {{$row->moto_license}}
                </td>


                {{-- <td>
                    {{$row->moto_number}}
                </td> --}}

                <td>
                    {{$row->license_renew_date}}
                </td>
                <td>
                    {{$row->license_expire_date}}
                </td>


                {{-- <td>
                    {{$row->type}}
                </td>

                <td>
                    {{$row->color}}
                </td> --}}
                <td>
                    {{$row->user->name}}
                </td>
                <td class="td-actions text-right">
                    @include('back-end.buttons.edit')
                    @include('back-end.buttons.delete')
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
    {{$rows->links()}}
</div>

@endcomponent

@endsection