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
                    @lang('site.status')
                </th>
                <th>
                    @lang('site.area_id')
                </th>
                <th>
                    @lang('site.delivery_id')
                </th>
                <th>
                    @lang('site.client_id')
                </th>
                <th>
                    @lang('site.feedback')
                </th>
                <th>
                    @lang('site.end_shoping_date')
                </th>
                <th>
                    @lang('site.arrival_date')
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
                <a class="btn btn-danger btn-sm" href="{{ route('orderdetails.index', ['order_id' => $row->id]) }}">
                     {{$row->orderDetails->count()}}   @lang("site.products") 
                    </a>  
                </td>

                <td>
                    @if ($row->status==0)
                        <a href="" class="btn btn-primary btn-sm">@lang("site.waiting")</a>
                    @else    
                        <a href="" class="btn btn-success btn-sm">@lang("site.finished")</a>
                    @endif
                </td>
                <td>
                    {{$row->area->name}}
                </td>
                <td>
                    @foreach ($users as $user)
                        @if($row->delivery_id==$user->id)
                            {{$user->firstName}} {{$user->lastName}}
                        @endif   
                    @endforeach
                </td>
                <td>
                    @foreach ($users as $user)
                        @if($row->client_id==$user->id)
                            {{$user->firstName}} {{$user->lastName}}
                        @endif   
                    @endforeach
                </td>
                <td>
                    {{$row->feedback}}
                </td>
                <td>
                     @if ($row->end_shoping_date==null)
                        <a href="" class="btn btn-primary btn-sm">@lang("site.not_buy")</a>
                     @else    
                        {{$row->end_shoping_date}}
                    @endif
                </td>
                <td>
                    @if ($row->arrival_date==null)
                        <a href="" class="btn btn-primary btn-sm">@lang("site.not_arrive")</a>
                    @else    
                        {{$row->arrival_date}}
                    @endif
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