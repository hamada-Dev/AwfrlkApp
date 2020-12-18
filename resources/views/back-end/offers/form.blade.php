{{csrf_field()}}
<div class="row">
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.offer_name')</label>
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
            <label class="bmd-label-floating">@lang('site.price')</label>
            <input type="text" name="price" value="{{ isset($row) ? $row->price : old('price') }}"
                class="form-control @error('price') is-invalid @enderror">
            @error('price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.trips_count')</label>
            <input type="text" name="trips_count" value="{{ isset($row) ? $row->trips_count : old('trips_count') }}"
                class="form-control @error('trips_count') is-invalid @enderror">
            @error('trips_count')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.offer_days')</label>
            <input type="text" name="offer_days" value="{{ isset($row) ? $row->offer_days : old('offer_days') }}"
                class="form-control @error('offer_days') is-invalid @enderror">
            @error('offer_days')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.avilable')</label>
            <select name="avilable" class="form-control @error('avilable') is-invalid @enderror">
                <option value="">@lang("site.avilable_situation")</option>
                <option value="0"  @if((isset($row) && $row->avilable==0)) selected @endif >@lang('site.Active')</option>
                <option value="1" @if((isset($row) && $row->avilable==1)) selected @endif>@lang('site.NotActive')</option>
            </select>
            @error('avilable')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.areas')</label>
            <select name="area_id" class="form-control @error('area_id') is-invalid @enderror">
                <option value="0">@lang('site.choose-area')</option>
                @foreach($areas as $area)
                <option value="{{$area->id}}" @if((isset($row) && $row->area_id == $area->id) || (request() != NULL && request()->area_id == $area->id ) || old('area_id') == $area->id) selected @endif>{{$area->name}}</option>
                @endforeach
            </select>
            @error('category_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
