@extends('back-end.layout.app')

@php
$type = request()->process ? __('site.Pending_orderes') : (request()->delivery ? __('site.orderDelivery') :
__('site.orderRoad') ) ;

@endphp
@section('title')
{{ $type }}
@endsection

@section('content')

@component('back-end.layout.nav-bar')


@slot('nav_title')
{{ $type }}
@endslot

@endcomponent

@component('back-end.partial.table', ['module_name_plural'=>'orders' ,
'module_name_singular'=> 'orders'])
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
                            @lang('site.order')
                        </th>

                        <th>
                            @lang('site.area_id')
                        </th>
                        <th>
                            @lang('site.order_type')
                        </th>

                    </tr>
                </thead>
                <tbody>
                    <tr>

                        <td>
                            <a href="{{ route('orderdetails.index', ['order_id' => $row->id]) }}">
                                {{$row->user->name . ' ' . $row->user->lastName}}</a>

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
                            {{ $row->type == 0 ? 'نقدي': ($row->type == 1  ? 'عرض' : 'برومو') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-body">
            <form action=" {{ request()->process ? route('pending.store') : '' }}" method="post">
                <div class="row">
                    <div class="col-md-3">
                        @csrf
                        <input type="hidden" name="order_id" value="{{$row->id}}">
                    </div>
                    <div class="col-md-4">
                        <div class="form-group bmd-form-group">
                            <select name="delivery_id" class="form-control @error('status') is-invalid @enderror"
                                {{$row->delivery_id != null? 'disabled' : ''}}>
                                <option value="0">@lang('site.choose_user_delivery')</option>
                                @foreach ($activeDelivery as $delivery)
                                <option value="{{$delivery->id}}" data-valu='{{ $row->delivery_id }}'
                                    {{ (isset($row) && $row->delivery_id == $delivery->id) || old('delivery_id') ==  $delivery->id  ? 'selected' : ''}}>
                                    {{$delivery->name . ''. $delivery->lasstName}}</option>
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
                        @if (request()->process)
                        <button type="submit" class="btn btn-lg btn-primary pull-right"> @lang('site.taklef')</button>
                        @else
                        <span class="btn btn-lg btn-success pull-right"> @lang('site.orderDelivery')</span>
                        @endif
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
                            {{ $detail->price != null ? $detail->price : __('site.cache') }}
                        </td>

                    </tr>
                    @endforeach
                </tbody>
                <tfoot style="background: #22477d; text-align: center">
                    <td></td>
                    <td>{{$countPro}}</td>
                    <td>{{$row->orderPrice}}</td>
                </tfoot>
            </table>

        </div>
    </div>
</div>
<hr>
@endforeach

{{ $rows->links() }}


@endcomponent

@endsection