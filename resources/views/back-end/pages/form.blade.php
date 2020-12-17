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
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.meta_keywords')</label>
            <input type="text" name="meta_keywords" value="{{ isset($row) ? $row->meta_keywords : old('meta_keywords') }}" class="form-control @error('meta_keywords') is-invalid @enderror">
            @error('meta_keywords')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.meta_desc')</label>
            <textarea name="meta_desc" class="form-control" cols="30" rows="10">{{ isset($row) ? $row->meta_desc : old('meta_desc') }}</textarea>
            @error('meta_desc')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.description')</label>
            <textarea name="description" class="form-control" cols="30" rows="10" >{{ isset($row) ? $row->description : old('description') }}</textarea>
            @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
