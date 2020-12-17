{{csrf_field()}}
<div class="row">
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.name')</label>
            <input type="text" name="name" value="{{ isset($row) ? $row->name : old('name') }}" class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>


    <div class="col-md-3">
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
            <img src="{{isset($row) ? asset('uploads/destinations_images/'. $row->image) : asset('uploads/trip_images/default.png')}}" width="100px" height="60px" class="img-thumbnail img-preview">
        </div>
    </div>
</div>
