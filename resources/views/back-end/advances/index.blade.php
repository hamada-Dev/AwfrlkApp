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
    <a href="{{route($module_name_plural.'.create', request() != NULL ? ['category_id'=> request()->category_id] : ''  ) }}"
        class="btn btn-white btn-round ">
        @lang('site.add') @lang('site.'.$module_name_singular)
    </a>
</div>
@endslot

<div class="table-responsive">
    <table class="table">
        <thead class=" text-primary text-center">
            <tr>
                <th>
                    @lang('site.id')
                </th>
                <th>
                    @lang('site.user_delivey')
                </th>
                <th>
                    @lang('site.getmoney')
                </th>
                <th>
                    @lang('site.givemoney')
                </th>
                <th>
                    @lang('site.from')
                </th>
                <th class="text-right">
                    @lang('site.actions')
                </th>
            </tr>
        </thead>
        <tbody class='text-center'>

            @foreach($rows as $row)

            <tr>
                <td>
                    {{$row->id}}
                </td>
                <td>
                    {{$row->user->name}} {{$row->user->lastName}}
                </td>
                <td>
                    {{$row->getmoney}}
                </td>
                <td>
                    @if($row->givemoney == null)
                    <a class="btn btn-primary btn-sm"
                        href="{{ route('advances.countreset', ['delivery_id' => $row->user_id, 'created_at'=>$row->created_at, 'id'=>$row->id]) }}">
                        @lang('site.count')
                    </a>
                    @else
                    {{$row->givemoney}}
                    @endif

                </td>
                <td>
                    {{$row->created_at}}

                </td>

                <td class="td-actions text-right">
                    <form action="{{ route('orders.index')}}" method="get">
                        <input type="hidden" value="{{$row->user_id}}" name="delivery_id">
                        <input type="hidden" value="{{$row->created_at}}" name="created_at">
                        <button rel="tooltip" title="" class="btn btn-white btn-link btn-sm"
                            data-original-title=" @lang('site.details_Orders')">
                            <i class="material-icons">calendar_today</i>
                        </button>
                    </form>

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