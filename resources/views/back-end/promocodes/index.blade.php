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
    <table class="table">
        <thead class=" text-primary">
            <tr>
                <th>
                    @lang('site.id')
                </th>
                <th>
                    @lang('site.user_name')
                </th>
                <th>
                    @lang('site.name')
                </th>
                <th>
                    @lang('site.serial')
                </th>
                <th>
                    @lang('site.confirm')
                </th>
                <td>
                @lang('site.discount')
                </td>
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
                    {{$row->user->firstName}} {{$row->user->lastName}}
                </td>
                <td>
                    {{$row->name}}
                </td>
                <td>
                    {{$row->serial}}
                </td>
                <td>
                    @if($row->confirm==1)
                         @lang('site.valide')
                    @else
                      <span style='color:red'>  @lang('site.notValide') </span>
                    @endif
                </td>
                <td>
                {{$row->discount}}%
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