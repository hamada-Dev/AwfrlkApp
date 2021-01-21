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
<div class="col-md-4 text-right">
    <a href="{{route($module_name_plural.'.index', ['offerNotPay' => 1])}}" class="btn btn-info btn-round ">
       @lang('site.offerNotPay')
    </a>
</div>
@endslot

<div class="table-responsive">
    <table id="dataTable" class="table">
        <thead class=" text-primary">
            <tr class='text-center'>
                <th>
                    @lang('site.id')
                </th>
                <th>
                    @lang('site.user')
                </th>
                <th>
                    @lang('site.offer')
                </th>
                <th>
                    @lang('site.price')
                </th>
                <th>
                    @lang('site.decrement_trip')
                </th>
                <th class="text-right">
                    @lang('site.actions')
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach($rows as $row)
            <tr class='text-center'>
                <td>
                    {{$row->id}}
                </td>
                <td>
                    {{$row->user->name}} {{$row->user->lastName}}
                </td>
                <td>
                    {{$row->offer->name}}
                </td>
                <td>
                    {{$row->price}}
                </td>
                <td>
                    {{$row->decrement_trip}}
                </td>
                <td class="td-actions text-right">
                    @include('back-end.buttons.edit')

                    @if(isset(request()->nonpay))
                    <form action="{{route($module_name_plural.'.destroy', $row)}}" method="POST"
                        style="display: inline-block">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <input type="hidden" name="userOfferNonPay" value="{{$row->id}}">
                        <button type="submit" rel="tooltip" title="" class="btn btn-white btn-link btn-sm delete"
                            data-original-title="@lang('site.delete')">
                            <i class="material-icons">close</i>
                        </button>
                    </form>

                    @else
                    @include('back-end.buttons.delete')
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