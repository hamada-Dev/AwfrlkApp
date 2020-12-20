{{csrf_field()}}
<div class="row">




<div class="col-md-6">
    <div class="form-group bmd-form-group">
        <label class="bmd-label-floating">@lang('site.order_id')</label>
        <select name="order_id" class="form-control @error('order_id') is-invalid @enderror">
            <option value="0">@lang('site.choose-order')</option>
            @foreach($orders as $order)
            <option value="{{$order->id}}" @if((isset($row) && $order->id== $row->order_id) || (request() != NULL && request()->order_id == $order->id ) || old('order_id') == $order->id) selected @endif>{{$order->id}} </option>
            @endforeach
        </select>
        @error('order_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="col-md-6">
    <div class="form-group bmd-form-group">
        <label class="bmd-label-floating">@lang('site.product_id')</label>
        <select name="product_id" class="form-control @error('product_id') is-invalid @enderror">
            <option value="0">@lang('site.choose-product')</option>
            @foreach($products as $product)
            <option value="{{$product->id}}" @if((isset($row) && $product->id== $row->product_id) || (request() != NULL && request()->product_id == $product->id ) || old('product_id') == $product->id) selected @endif>{{$product->name}} @lang("site.price") {{$product->price}} /{{ $product->unit}} </option>
            @endforeach
        </select>
        @error('product_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="col-md-12">
    <div class="form-group bmd-form-group">
        <label class="bmd-label-floating">@lang('site.amount')</label>
        <input type="text" name="amount" value="{{ isset($row) ? $row->amount : old('amount') }}"
            class="form-control @error('amount') is-invalid @enderror">
        @error('amount')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
</div>
