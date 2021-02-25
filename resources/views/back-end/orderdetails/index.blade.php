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
    @if (!request()->trash)
    <a href="{{route($module_name_plural.'.edit', ['orderdetail' => request()->order_id, 'orderType' => $orderType]) }}"
        class="btn btn-white btn-round ">
        @lang('site.edit') @lang('site.'.$module_name_singular)
    </a>
    @endif

</div>
@endslot
<!-- order type is usauly -->
@if(isset($orderType) && $orderType==0)
<div class="table-responsive">
    <table id="dataTable" class="table">
        <thead class=" text-primary">
            <tr>
                <th>
                    @lang('site.id')
                </th>
                <th>
                    @lang('site.product_id')
                </th> 
                <th>
                    @lang('site.category')
                </th>
                <th>
                    @lang('site.amount')
                </th>
                <th>
                    @lang('site.unit')
                </th>
                <th>
                    @lang('site.price')
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
                    {{ ($row->product_id == null) ? 'image' : $row->product->name}}
                </td> 
                <td>
                    {{ $row->product->category->name }}
                </td>
                <td>
                    {{$row->amount}}
                </td>
                <td>
                    {{__('site.'.$row->product->unit)}}
                </td>
                <td>
                    {{($row->price == null) ? 'after buy' :$row->price }}
                </td>


            </tr>
            @endforeach

        </tbody>
    </table>
    {{$rows->links()}}
</div>
@elseif(isset($orderType) && $orderType==1)
<!-- start place tp place -->
<div class="table-responsive">
    <table id="dataTable" class="table">
        <thead class=" text-primary">
            <tr>
                <th>
                    @lang('site.id')
                </th>
                <th>
                    @lang('site.order_id')
                </th>
                <th>
                    @lang('site.description')
                </th>
                <th>
                    @lang('site.adressFrom')
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
                    {{$row->order_id}}
                </td>
                <td>
                    {{$row->description}}
                </td>
                <td>
                    {{$row->product_home}}
                </td>

            </tr>
            @endforeach

        </tbody>
    </table>
    {{$rows->links()}}
</div>
@elseif(isset($orderType) && $orderType==2)
<!-- order type is pharmacy -->
<div class="table-responsive">
    <table id="dataTable" class="table">
        <thead class=" text-primary">
            <tr>
                <th>
                    @lang('site.id')
                </th>

                <th>
                    @lang('site.order_id')
                </th>
                <th>
                    @lang('site.image')
                </th>

                <th>
                    @lang('site.description')
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
                    {{$row->order_id}}
                </td>
                <td>
                    <img src="{{$row->imagePath}}" alt="" width='60' height='60'>
                </td>
                <td>
                    {{$row->description}}
                </td>

            </tr>
            @endforeach

        </tbody>
    </table>
    {{$rows->links()}}
</div>
@endif
@endcomponent

@endsection