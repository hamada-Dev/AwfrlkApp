{{csrf_field()}}
<div class="row">
    <div class="col-md-6">
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
            <label class="bmd-label-floating">@lang('site.trans_price')</label>
            <input type="text" name="trans_price" value="{{ isset($row) ? $row->trans_price : old('trans_price') }}"
                class="form-control @error('trans_price') is-invalid @enderror">
            @error('trans_price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>


    <div class="col-md-12">
        <div class="form-group bmd-form-group">
            <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                <option value="0">@lang('site.choose-govern')</option>
                @foreach($areas as $area)
                <option value="{{$area->id}}" @if((isset($row) && $area->id== $row->parent_id) || (request() != NULL && request()->parent_id == $area->id ) || old('parent_id') == $area->id) selected @endif>{{$area->name}}</option>
                @endforeach
            </select>
            @error('parent_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
