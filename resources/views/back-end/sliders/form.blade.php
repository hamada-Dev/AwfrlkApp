{{csrf_field()}}
<div class="row">
    <div class="col-md-12">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.description')</label>
            <input type="text" name="description" value="{{ isset($row) ? $row->description : old('description') }}" class="form-control @error('description') is-invalid @enderror">
            @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>


    <div class="col-md-6">
        <div class="">
            <label>@lang('site.image')</label>
            <input type="file" name="image" value="" class="form-control image @error('image') is-invalid @enderror">
            @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-3" width="100px" height="60px">
        <div class="">
            <img src="{{isset($row) ? $row->image_path : asset('uploads/products_images/default.png')}}" width="100px" height="60px" class="img-thumbnail img-preview">
        </div>
    </div>
</div>
