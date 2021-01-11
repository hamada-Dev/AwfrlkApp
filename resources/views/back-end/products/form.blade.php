{{csrf_field()}}
<div class="row">
    <div class="col-md-12">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.name')</label>
            <input type="text" name="name" value="{{ isset($row) ? $row->name : old('name') }}"
                class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                <option value="0">@lang('site.choose-category')</option>
                @foreach($categories as $category)
                <option value="{{$category->id}}" @if((isset($row) && $row->category_id == $category->id) || (request() != NULL && request()->category_id == $category->id ) || old('category_id') == $category->id) selected @endif>{{$category->name}}</option>
                @endforeach
            </select>
            @error('category_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    @php
    $unitsArray = ['kilo', 'liter', 'number'];
    // $unitsArray = ['kilo', 'liter', 'number'];
    @endphp
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <select name="unit" class="form-control @error('unit') is-invalid @enderror">
                <option value="0">@lang('site.choose-unit')</option>
                @foreach($unitsArray as $unit)
                <option value="{{$unit}}" @if((isset($row) && $row->unit == $unit) || old('unit') == $unit) selected @endif >{{$unit}}</option>
                @endforeach
            </select>
            @error('unit')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                <option value="0">@lang('site.choose-product_cat')</option>
                @foreach(App\Models\Product::where('parent_id',0)->get() as $product)
                <option value="{{$product->id}}" @if((isset($row) && $product->id== $row->parent_id) || (request() != NULL && request()->product_id == $product->id ) || old('product_id') == $product->id) selected @endif>{{$product->name}} </option>
                @endforeach
            </select>
            @error('parent_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <div class="form-group bmd-form-group">
                <label class="bmd-label-floating">@lang('site.price')</label>
                <input type="number" min="0" step="0.1" name="price" value="{{ isset($row) ? $row->price : old('price') }}"
                    class="form-control @error('price') is-invalid @enderror">
                @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-md-3">
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
        <div class="">
            <img src="{{isset($row) ?  $row->image_path : asset('uploads/products_images/default.png')}}" width="100px"
                style="height: 100px" class="img-thumbnail img-preview">
        </div>
    </div>



</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.description')</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" cols="30"
                rows="5">{{ isset($row) ? $row->description : old('description') }}</textarea>
            @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>