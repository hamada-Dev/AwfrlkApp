@extends('back-end.layout.app')

@php

@endphp
@section('title')
@lang('site.Pending_orderes')
@endsection

@section('content')

@component('back-end.layout.nav-bar')

@slot('nav_title')
@lang('site.Pending_orderes')
@endslot

@endcomponent

@component('back-end.partial.table', ['module_name_plural'=>'Pending_orderes' ,
'module_name_singular'=> 'Pending_orderes'])
@slot('add_button')
<div class="col-md-4 text-right">

</div>
@endslot


@foreach($rows as $row)
<div class="row">
    <div class="col-md-8">
        <div class="table-responsive">
            <table class="table">
                <thead class=" text-primary">
                    <tr>
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
                            @lang('site.type')
                        </th>

                        <th>
                            @lang('site.area_id')
                        </th>
                        <th>
                            @lang('site.deliveryType')
                        </th>

                    </tr>
                </thead>
                <tbody>
                    <tr>

                        <td>
                            {{$row->user->name . ' ' . $row->user->lastName}}
                        </td>
                        <td>
                            {{$row->user->phone}}
                        </td>
                        <td>
                            {{$row->user->adress}}
                        </td>
                        <td>
                            @if($row->orderDetails[0]->product_id != null) @lang('site.products')
                            @elseif($row->orderDetails[0]->image != null) @lang('site.pharmacy') @else
                            @lang('site.homeToHome') @endif
                        </td>
                        <td>
                            {{$row->area->name}}
                        </td>


                        <td>
                            {{ $row->type == 0 ? 'cache': ($row->type == 1  ? 'offer' : 'promo') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-body">
            <form action="{{ route('pending.store') }}" method="post">
                <div class="row">
                    <div class="col-md-3">
                        @csrf
                        <input type="hidden" name="order_id" value="{{$row->id}}">
                    </div>
                    <div class="col-md-4">
                        <div class="form-group bmd-form-group">
                            <select name="delivery_id" class="form-control @error('status') is-invalid @enderror">
                                <option value="0">@lang('site.choose-Delivery')</option>
                                @foreach ($activeDelivery as $delivery)
                                    <option value="{{$delivery->id}}">{{$delivery->name . ''. $delivery->lasstName}}</option>
                                @endforeach
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-primary pull-right"> @lang('site.taklef')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4" style="background: #8d399f36;">
        <div class="table-responsive table table-info">
            <table class="table" style="background: #0d1c32;">
                <thead class=" text-primary">
                    <tr>
                        <th>
                            @lang('site.product')
                        </th>
                        <th>
                            @lang('site.amount')
                        </th>

                        <th>
                            @lang('site.price')
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @php
                    $countPro = 0;
                    @endphp
                    @foreach($row->orderDetails as $detail)
                    <tr>
                        <td>
                            @if($detail->product_id != null) {{$detail->product->name}}
                            @elseif($detail->image != null) <img src="" alt="">
                            @else {{$detail->product_home}} @endif
                        </td>
                        <td>
                            {{ $detail->amount != null ? $detail->amount : '-' }}
                            @php
                            $countPro += ($detail->amount != null ? $detail->amount : 1 )
                            @endphp
                        </td>
                        <td>
                            {{ $detail->price != null ? $detail->price : 'cache' }}
                        </td>

                    </tr>
                    @endforeach
                </tbody>
                <tfoot style="background: #22477d">
                    <td></td>
                    <td>{{$countPro}}</td>
                    <td>{{$row->orderPrice}}</td>
                </tfoot>
            </table>

        </div>
    </div>
</div>
<hr>
<hr>
<hr>
@endforeach




@endcomponent

@endsection