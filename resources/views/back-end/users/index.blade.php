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
    <a href="{{route($module_name_plural.'.create', ['group'=> 'emp'])}}" class="btn btn-white btn-round ">
        @lang('site.add') @lang('site.emp')
    </a>
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
                    @lang('site.adress')
                </th>
                <th>
                    @lang('site.area')
                </th>
                <th>
                    @lang('site.image')
                </th>

                <th>
                    @lang('site.salary')
                </th>
                <th class="text-right">
                    @lang('site.actions')
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach($rows as $row)

            <tr>
                <td> {{$row->id}}</td>
                <td>
                    <a href="{{route('usersalaries.index',['user_id'=>$row->id])}}" title="@lang('site.all_salary')">
                        {{$row->name .' '. $row->lastName}}
                    </a>
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
                    @if($row->group !='user')
                    @if(in_array($row->id,$whotakemoney))
                    <a href="" class='btn btn-sm btn-warning'>@lang('site.takeHereMoney')</a>
                    @else
                    <a href="{{route('usersalaries.show',$row->id)}}"
                        class='btn btn-sm btn-primary'>@lang('site.give_money')</a>
                    @endif
                    @endif

                </td>
                {{-- request()->group --}}
                <td class="td-actions text-right">
                    <a href="{{route($module_name_plural.'.edit', ['user' =>$row, 'group' => 'emp'])}}" rel="tooltip" title=""
                        class="btn btn-white btn-link btn-sm" data-original-title="@lang('site.edit')">
                        <i class="material-icons">edit</i>
                    </a>
                    {{-- @include('back-end.buttons.edit') --}}
                    @include('back-end.buttons.delete')
                    @if($row->delivery_status != 3)

                    <a href="{{route('users.blacklist',$row->id)}}" rel="tooltip"
                        title="@lang('site.add') @lang('site.black_list')" class="btn btn-white btn-link btn-sm"
                        data-original-title="@lang('site.black_list')">
                        <i class="material-icons">pan_tool</i>
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