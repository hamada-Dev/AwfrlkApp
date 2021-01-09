@extends('back-end.layout.app')

@php

@endphp
@section('title')
@lang('site.black_list')
@endsection

@section('content')

@component('back-end.layout.nav-bar')

@slot('nav_title')
@lang('site.black_list')
@endslot

@endcomponent

@component('back-end.partial.table', ['module_name_plural'=>'black_list' , 'module_name_singular'=>'black_list'])
@slot('add_button')
<div class="col-md-4 text-right">
    <!-- <a href="{{route($module_name_plural.'.create')}}" class="btn btn-white btn-round ">
                    @lang('site.add') @lang('site.delivery')
                </a> -->
</div>
@endslot
<div class="table-responsive">
    <table id="dataTable" class="table">
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
                    @lang('site.area')
                </th>
                <th>
                    @lang('site.adress')
                </th>
                 <th>
                    @lang('site.image')
                </th>
                <th>
                    @lang('site.group')
                </th>
                <th>
                    @lang('site.delivery_status')
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
                    {{$row->name}} {{$row->lastName}}
                </td>
                <td>
                    {{$row->phone}}
                </td>

                <td>
                    {{$row->area->name}}
                </td>

                <td>
                    {{$row->adress}}
                </td>
                <td>
                    <img class="img-thumbnail img-preview" src="{{$row->image_path}}" alt="" srcset="" height="100"
                        width="100">
                </td>

                <td>
                    @lang('site.'.$row->group)
                </td>
                <td>
                    @if($row->delivery_status == 3)
                    <a class="btn btn-danger btn-sm" href="{{route('users.blacklist',$row->id)}}">
                        @lang('site.delete') @lang('site.black_list')
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