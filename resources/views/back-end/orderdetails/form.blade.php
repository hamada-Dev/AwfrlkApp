{{csrf_field()}}
<input type="hidden" name="delivery_id" value="{{session()->get('delivery_id')}}">
<input type="hidden" name="client_id" value="{{session()->get('client_id')}}">
<input type="hidden" name="note" value="{{session()->get('note')}}">
<div class="row">


    @if(request()->orderType==2)
    {{-- orderType==2 that mean this is a pharmacy order   --}}
    <input type="hidden" name="pharmacy" value="1">
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

    <div class="col-md-3" width="100px" height="60px">
        <div class="form-group bmd-form-group">
            <img src="{{isset($row) ?  $row[0]->image_path : asset('uploads/orders_images/order.png')}}" width="100px"
                style="height: 100px" class="img-thumbnail img-preview">
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.description')</label>
            <input type="text" name="description" value="{{ isset($row) ? $row[0]->description : old('description') }}"
                class="form-control @error('description') is-invalid @enderror">
            @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>


    @elseif(request()->orderType==1)
    {{-- orderType== 1 this order is from home to home  --}}

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <select name="area_id_from" class="form-control @error('area_id_from') is-invalid @enderror"
                {{isset($orders) ? 'disabled' : ''}}>
                <option value="0">@lang('site.from-area')</option>
                @foreach( \App\Models\Area::all() as $area)
                <option value="{{$area->id}}" @if((isset($orders) && $area->id == $orders->area_id_from) ||
                    old('area_id_from') == $area->id) selected @endif>
                    {{$area->name}}
                </option>
                @endforeach
            </select>
            @error('area_id_from')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.adress_from')</label>
            <input type="text" name="adress_from"
                value="{{ isset($orders) ? $orders->adress_from : old('adress_from') }}"
                class="form-control @error('adress_from') is-invalid @enderror">
            @error('adress_from')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.product_home')</label>
            <textarea name="product_home" cols="10" rows="5"
                class="form-control @error('product_home') is-invalid @enderror">{{ isset($row) ? $row[0]->product_home : old('product_home') }}</textarea>
            @error('product_home')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.description')</label>
            <textarea name="description" cols="10" rows="5"
                class="form-control @error('description') is-invalid @enderror"> {{ isset($row) ? $row[0]->description : old('description') }} </textarea>
            @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    @else
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">

                <div class="col-md-6">
                    <div class="form-group bmd-form-group">
                        <label class="bmd-label-floating">@lang('site.amount')</label>
                        <input id='amount' type="number" step="0.1" name=""
                            value="{{ (old('amount') != null ? old('amount') : 1) }}"
                            class="form-control @error('amount') is-invalid @enderror">
                        @error('amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group bmd-form-group">
                        <label class="bmd-label-floating">@lang('site.product')</label>
                        <select id='productId' name="" class="form-control @error('product_id') is-invalid @enderror">
                            <option value="0">@lang('site.choose-product')</option>
                            @foreach($products as $product)
                            <option data-proname='{{$product->name}}' data-proprice='{{$product->price}}'
                                value="{{$product->id}}" @if( old('product_id')==$product->id) selected
                                @endif>{{$product->name}} @lang("site.price") {{$product->price}}
                                /{{ $product->unit}} </option>
                            @endforeach
                        </select>
                        @error('product_id')
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
                                <th>
                                    @lang('site.price')
                                </th>
                                <th class="text-right">
                                    @lang('site.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($row)
                            @forelse ($row as $item)
                            <tr>
                                <td> <input type='hidden' name='product_id[]' value='{{$item->product_id}}'></td>
                                <td> {{$item->product->name}} </td>
                                <td> {{$item->amount}} <input type='hidden' name='amount[]' value='{{$item->amount}}'>
                                </td>
                                <td> {{$item->price}} <input type='hidden' name='price[]' value='{{$item->price}}'></td>
                                <td><button class='removeRow btn btn-danger' data-proid='${productid}'>R</button></td>
                            </tr>
                            @empty

                            @endforelse
                            @endisset
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    @endif

</div>