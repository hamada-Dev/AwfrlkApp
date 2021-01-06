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
    <a href="{{route($module_name_plural.'.create')}}" class="btn btn-white btn-round ">
        @lang('site.add') @lang('site.'.$module_name_singular)
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
                <th>@lang('site.black_list')</th>
                <th>
                    @lang('site.name')
                </th>
                <th>
                    @lang('site.email')
                </th>
                <th>
                    @lang('site.phone')
                </th>
                <th>
                    @lang('site.gender')
                </th>
                <th>
                    @lang('site.country')
                </th>
                <th>
                    @lang('site.status')
                </th>

                <th>
                    @lang('site.group')
                </th>
                <th class="text-right">
                    @lang('site.actions')
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach($rows as $row)

            <tr>
                <td>{{$row->id}}</td>
                <td>
                    
                    @if($row->delivery_status != 3)
                    <a href="{{route('users.blacklist',$row->id)}}" rel="tooltip" title="@lang('site.black_list')"
                        class="btn btn-white btn-link btn-sm" data-original-title="">
                        <i class="material-icons">pan_tool</i>
                    </a>
                    @endif
                </td>

                <td>
                    {{$row->name}} {{$row->lastName}}
                </td>

                <td>
                    {{$row->email}}
                </td>

                <td>
                    {{$row->phone}}
                </td>

                <td>
                    {{$row->gender}}
                </td>

                <td>
                    {{$row->adress}}
                </td>
                <th>
                    @if($row->delivery_status==0)
                    <a href="{{route('users.deliverystatus',$row->id)}}" class='btn btn-success btn-sm'>
                        @lang('site.busy')
                    </a>
                    @elseif($row->delivery_status==1)
                    <a href="{{route('users.deliverystatus',$row->id)}}" class='btn btn-danger btn-sm'>
                        @lang('site.active')
                    </a>
                    @elseif($row->delivery_status==2)
                    <a href="{{route('users.deliverystatus',$row->id)}}" class='btn btn-primary btn-sm'>
                        @lang('site.notActive')
                    </a>
                    @elseif($row->delivery_status==3)
                    <a href="{{route('users.deliverystatus',$row->id)}}" class='btn btn-alert btn-sm'>
                        @lang('site.black_list')
                    </a>
                    @else
                    @endif
                </th>

                <td>
                    {{$row->group}}
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