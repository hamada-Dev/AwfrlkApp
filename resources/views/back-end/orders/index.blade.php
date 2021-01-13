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

@component('back-end.partial.table', ['module_name_plural'=>$module_name_plural
,'module_name_singular'=>$module_name_singular])

@slot('add_button')
<div class="col-md-4 text-right">
    <a href="{{route($module_name_plural.'.create', request() != NULL ? ['category_id'=> request()->category_id] : ''  ) }}"
        class="btn btn-white btn-round ">
        @lang('site.add') @lang('site.'.$module_name_singular)
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
                    @lang('site.totalPrice')
                </th>
                <th>
                    @lang('site.status')
                </th>
                <th>
                    @lang('site.type_count')
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
                    @lang('site.end_shoping_date')
                </th>
                <th>
                    @lang('site.arrival_date')
                </th>
                <th>
                    @lang("site.delivery_price")
                </th>

                <th class="text-right">
                    @lang('site.actions')
                </th>
            </tr>
        </thead>
        <tbody>
            @php
            $sumtotal=0;
            $sumdel=0;
            $orderType = 0;
            @endphp
            @foreach($rows as $row)
            @php
                if($row->area_id_from != null){
                    $orderType = 1; // hom to home 
                }elseif($row->orderDetails[0]->product_id  == null){ 
                    $orderType = 2; // pharmacy 
                }else{
                    $orderType = 0; // product order
                }

            @endphp
            <tr>
                <td>
                    <a class="btn btn-danger btn-sm" href="{{ route('orderdetails.index', ['order_id' => $row->id]) }}">
                        {{$row->orderDetails->count()}} @lang("site.products")
                    </a>
                </td>
                <td>
                    {{$row->orderDetails->sum('price')}}
                    @php
                    $sumtotal+=$row->orderDetails->sum('price');
                    @endphp
                </td>
                <td>
                    @if ($row->status==0)
                    <a href="" class="btn btn-primary btn-sm">@lang("site.waiting")</a>
                    @else
                    <a href="" class="btn btn-success btn-sm">@lang("site.finished")</a>
                    @endif
                </td>
                <td>
                    @if($row->type==0)
                    @lang('site.usual')
                    @elseif($row->type==1)
                    @lang('site.offer')
                    @else
                    @lang('site.promocode')
                    @endif
                </td>
                <td>
                    {{$row->area->name}}
                </td>
                <td>
                    @if($row->delivery_id != null)
                    @foreach ($users as $user)
                    @if($row->delivery_id==$user->id)
                    {{$user->name}} {{$user->lastName}}
                    @endif
                    @endforeach
                    @else
                    <a href="" class="btn btn-success btn-sm">@lang("site.noDelivery")</a>
                    @endif
                </td>
                <td>
                    @foreach ($users as $user)
                    @if($row->client_id==$user->id)
                    {{$user->name}} {{$user->lastName}}
                    @endif
                    @endforeach
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
                <td>
                    {{ $row->delivery_price }}
                    @php
                    $sumdel+=$row->delivery_price;
                    @endphp
                </td>

                <td class="td-actions text-right">
                    <a href="{{route('orderdetails.edit', ['orderdetail' => $row->id, 'orderType'=> $orderType]) }}" rel="tooltip" title=""
                        class="btn btn-white btn-link btn-sm" data-original-title="@lang('site.edit')">
                        <i class="material-icons">edit</i>

                    </a> @include('back-end.buttons.delete')
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>
                    -
                </th>

                <th>
                    @php echo $sumtotal; @endphp
                </th>

                <th>
                    -
                </th>
                <th>
                    -
                </th>
                <th>
                    -
                </th>
                <th>
                    -
                </th>
                <th>
                    -
                </th>
                <th>
                    -
                </th>
                <th>
                    @php echo $sumdel; @endphp
                </th>

                <th>
                    -
                </th>
            </tr>
        </tfoot>
    </table>
    {{$rows->links()}}
</div>

@endcomponent

@endsection