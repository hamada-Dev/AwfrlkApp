@extends('back-end.layout.app')

@php

@endphp
@section('title')
@lang('site.usersShow')
@endsection

@section('content')

@component('back-end.layout.nav-bar')

@slot('nav_title')
@lang('site.usersShow')
@endslot

@endcomponent

@component('back-end.partial.table', ['module_name_plural'=>'usersShow' , 'module_name_singular'=>'usersShow'])
@slot('add_button')
<div class="col-md-4 text-right">
    <a href="{{route($module_name_plural.'.create', ['group'=> 'user'])}}" class="btn btn-white btn-round ">
        @lang('site.add') @lang('site.usersShow')
    </a>
</div>
@endslot
<div class="table-responsive">
    <table class="table">
        <thead class=" text-primary">
            <tr>
                <th>
                    @lang('site.id')

                </th>

                <th>
                    @lang('site.name')
                </th>
                <th>
                    @lang('site.phone')
                </th>
                <th>
                    @lang('site.adress')
                </th>
                <th>
                    @lang('site.area')
                </th>

                <th>
                    @lang('site.image')
                </th>

                <th>
                    @lang('site.orders')
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
                    {{-- <a href="{{route('usersalaries.index',['user_id'=>$row->id])}}"
                    title="@lang('site.all_salary')"></a> --}}
                    {{$row->name}} {{$row->lastName}}
                </td>

                <td>
                    {{$row->phone}}
                </td>
                <td>
                    {{$row->adress}}
                </td>

                <td>
                    {{$row->area->name}}
                </td>
                <td>
                    <img class="img-thumbnail img-preview" src="{{$row->image_path}}" alt="" srcset="" height="100"
                        width="100">
                </td>


                <td>
                    {{$row->order_countU}}
                </td>

                <td class="td-actions text-right">
                    @include('back-end.buttons.edit')
                    @include('back-end.buttons.delete')

                    @if($row->delivery_status != 3)
                    <a href="{{route('users.blacklist',$row->id)}}" rel="tooltip"
                        title="@lang('site.add') @lang('site.black_list')" class="btn btn-white btn-link btn-sm"
                        data-original-title="@lang('site.black_list')">
                        <i class="material-icons">pane_tool</i>
                    </a>
                    @endif
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
    {{$rows->links()}}
</div>

@endcomponent

@endsection