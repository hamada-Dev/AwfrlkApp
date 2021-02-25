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
<div class="col-md-3 text-right">
    <a href="{{route($module_name_plural.'.create', request() != NULL ? ['category_id'=> request()->category_id] : ''  ) }}"
        class="btn btn-white btn-round ">
        @lang('site.add') @lang('site.'.$module_name_singular)
    </a>
</div>

<div class="col-md-1">
    <a href="{{ route('orders.index',['trash'=> 1]) }}">
        <i class="material-icons" style="font-size: 22px">delete</i>
    </a>
</div>
@endslot

<div class="table-responsive">
    <table id="dataTable" class="table table-hover">
        <thead class=" text-primary">
            <tr>
                <th>
                    @lang('site.id')
                </th>
                <th>
                    @lang('site.product')
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
                @if (request()->trash)
                   <th>
                    @lang("site.supervisor")
                </th> 
                @endif 
                

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
            @foreach($rows as $index => $row)
            @php
            if($row->area_id_from != null){
            $orderType = 1; $trans = __('site.fromto'); // hom to home
            }elseif($row->orderDetails[0]->product_id == null){
            $orderType = 2; $trans = __('site.pharmacy'); // pharmacy
            }else{
            $orderType = 0; $trans = __('site.usual'); // product order
            }
            @endphp
            <tr>
                <td>
                    {{ ++$index }}
                </td>
                <td>
                    <a class="text text-info sm" href="{{ route('orderdetails.index', ['order_id' => $row->id,  request()->trash ? 'trash=1' : '', ]) }}">
                        <small>{{$trans}} </small>{{-- @lang("site.products") --}}
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
                    <span class="btn btn-primary btn-sm">@lang("site.waiting")</span>
                    {{-- <a href="" class="btn btn-primary btn-sm">@lang("site.waiting")</a> --}}
                    @else
                    <span class="btn btn-success btn-sm">@lang("site.finished")</span>
                    {{-- <a href="" class="btn btn-success btn-sm">@lang("site.finished")</a> --}}
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
                    <a href="{{route('pending.index', ['process'  => 1])}}"
                        class="btn btn-danger btn-sm">@lang("site.noDelivery")</a>
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
                    <span class="btn btn-warning btn-sm">@lang("site.not_buy")</span>
                    {{-- <a href="" class="btn btn-primary btn-sm">@lang("site.not_buy")</a> --}}
                    @else
                    {{ date('H:i y-m-d ', strtotime($row->end_shoping_date))}}
                    @endif
                </td>
                <td>
                    @if ($row->arrival_date==null)
                    <span class="btn btn-dark btn-sm">@lang("site.not_arrive")</span>
                    {{-- <a href="" class="btn btn-primary btn-sm">@lang("site.not_arrive")</a> --}}
                    @else
                    {{date('H:i y-m-d ', strtotime($row->arrival_date))}}
                    @endif
                </td>
                <td>
                    {{ $row->delivery_price }}
                    @php
                    $sumdel+=$row->delivery_price;
                    @endphp
                </td>

                @if (request()->trash)
                    <td class="text text-danger">
                        {{$row->supervisor->name}}
                    </td>
                @endif 

                <td class="td-actions text-right">
                    @if (request()->trash)
                    <form action="{{ route('order.trash') }}" method="post">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $row->id }} ">
                        <button class="btn btn-sm btn-success delete"> back </button>
                    </form>
                        
                    @else
                    <a href="{{route('orderdetails.edit', ['orderdetail' => $row->id, 'orderType'=> $orderType]) }}"
                        rel="tooltip" title="" class="btn btn-white btn-link btn-sm"
                        data-original-title="@lang('site.edit')">
                        <i class="material-icons">edit</i>

                    </a> @include('back-end.buttons.delete')
                    @endif

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
                </th> <th>
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

               
            </tr>
        </tfoot>
    </table>
    {{$rows->appends(request()->query())->links()}}

</div>

@endcomponent

@endsection