{{csrf_field()}}
<div class="row">

@if($order_type==0)
<div class="col-md-12">
<div class="row">
<div class="col-md-6">
    <div class="col-md-12">
        <div class="form-group bmd-form-group">
            <select id='order_id' name="order_id" class="form-control @error('order_id') is-invalid @enderror">
                @if($order_id !=null)
                    <option value="{{$order_id}}">{{$order_id}} </option>
                @else
                    <option value="0">@lang('site.choose-order')</option>
                    @foreach($orders as $order)
                        <option value="{{$order->id}}" @if((isset($row) && $order->id== $row->order_id) || (request() != NULL && request()->order_id == $order->id ) || old('order_id') == $order->id) selected @endif>{{$order->id}} </option>
                    @endforeach
                @endif
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
            <select id='product_id' name="product_id" class="form-control @error('product_id') is-invalid @enderror">
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
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.amount')</label>
            <input id='amount' type="text" name="amount" value="{{ isset($row) ? $row->amount : old('amount') }}"
                class="form-control @error('amount') is-invalid @enderror">
            @error('amount')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <a class='btn btn-primary' id='addButton'>أضف الطلب</a>
</div>
<div class="col-md-6">
<div class="table-responsive">
    <table class="table" id='orderTable'>
        <thead class=" text-primary">
            <tr>
                <th>
                    @lang('site.id')
                </th>
                <th>
                    @lang('site.product_id')
                </th>
                <th>
                    @lang('site.amount')
                </th>
                <th class="text-right">
                    @lang('site.actions')
                </th>
            </tr>
        </thead>
        <tbody>

        </tbody>   
    </table>
</div>

</div>
</div>
</div>
@elseif($order_type==1)
<div class="col-md-12">
    <div class="form-group bmd-form-group">
        <select name="order_id" class="form-control @error('order_id') is-invalid @enderror">
            @if($order_id !=null)
                <option value="{{$order_id}}">{{$order_id}} </option>
            @else
                <option value="0">@lang('site.choose-order')</option>
                 @foreach($orders as $order)
                      <option value="{{$order->id}}" @if((isset($row) && $order->id== $row->order_id) || (request() != NULL && request()->order_id == $order->id ) || old('order_id') == $order->id) selected @endif>{{$order->id}} </option>
                 @endforeach
            @endif
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
        <select name="area_from" class="form-control @error('area_from') is-invalid @enderror">
            <option value="0">@lang('site.from-area')</option>
            @foreach( \App\Models\Area::all() as $area)
            <option value="{{$area->id}}" @if((isset($row) && $product->id== $row->area_id) || (request() != NULL && request()->area_id == $area->id ) || old('area_from') == $area->id) selected @endif> {{$area->name}}</option>
            @endforeach
        </select>
        @error('area_from')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="col-md-6">
    <div class="form-group bmd-form-group">
        <select name="area_to" class="form-control @error('area_to') is-invalid @enderror">
            <option value="0">@lang('site.to-area')</option>
            @foreach( \App\Models\Area::all() as $area)
            <option value="{{$area->id}}" @if((isset($row) && $product->id== $row->area_id) || (request() != NULL && request()->area_id == $area->id ) || old('area_from') == $area->id) selected @endif> {{$area->name}}</option>
            @endforeach
        </select>
        @error('area_to')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="col-md-12">
    <div class="form-group bmd-form-group">
        <label class="bmd-label-floating">@lang('site.description')</label>
        <input type="text" name="description" value="{{ isset($row) ? $row->amount : old('amount') }}"
            class="form-control @error('description') is-invalid @enderror">
        @error('description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

@else
<div class="col-md-12">
    <div class="form-group bmd-form-group">
        <select name="order_id" class="form-control @error('order_id') is-invalid @enderror">
            @if($order_id !=null)
                <option value="{{$order_id}}">{{$order_id}} </option>
            @else
                <option value="0">@lang('site.choose-order')</option>
                 @foreach($orders as $order)
                      <option value="{{$order->id}}" @if((isset($row) && $order->id== $row->order_id) || (request() != NULL && request()->order_id == $order->id ) || old('order_id') == $order->id) selected @endif>{{$order->id}} </option>
                 @endforeach
            @endif
        </select>
        @error('order_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="col-md-6">
        <div class="">
            <label>@lang('site.image')</label>
            <input type="file" name="image" class="form-control image @error('image') is-invalid @enderror">
            @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6" width="100px" height="60px">
        <div class="">
            <img src="{{isset($row) ?  $row->image : asset('uploads/orders_images/order.jpeg')}}" width="100px"
                style="height: 100px" class="img-thumbnail img-preview">
        </div>
    </div>

<div class="col-md-12">
    <div class="form-group bmd-form-group">
        <label class="bmd-label-floating">@lang('site.description')</label>
        <input type="text" name="description" value="{{ isset($row) ? $row->amount : old('amount') }}"
            class="form-control @error('description') is-invalid @enderror">
        @error('description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
@endif






</div>
