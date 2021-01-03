{{csrf_field()}}
<div class="row">

<div class="col-md-6">
    <div class="form-group bmd-form-group">
        <select name="status" class="form-control @error('status') is-invalid @enderror">
            <option value="">@lang('site.choose-status')</option>
            <option value="0" @if(isset($row) && $row->status=0) selected  @endif >@lang('site.waiting')</option>
            <option value="1"  @if(isset($row) && $row->status=1) selected  @endif>@lang('site.finished')</option>
        </select>
        @error('status')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>


<div class="col-md-6">
    <div class="form-group bmd-form-group">
        <select name="delivery_id" class="form-control @error('delivery_id') is-invalid @enderror">
            <option value="0">@lang('site.choose-deliver')</option>
            @foreach($delivers as $deliver)
            <option value="{{$deliver->id}}" @if((isset($row) && $deliver->id== $row->delivery_id) || (request() != NULL && request()->delivery_id == $deliver->id ) || old('delivery_id') == $deliver->id) selected @endif>{{$deliver->name}} {{$deliver->lastName  }} </option>
            @endforeach
        </select>
        @error('delivery_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="col-md-6">
    <div class="form-group bmd-form-group">
        <select name="client_id" class="form-control @error('client_id') is-invalid @enderror">
            <option value="0">@lang('site.choose-client')</option>
            @foreach($users as $user)
            <option value="{{$user->id}}" @if((isset($row) && $user->id== $row->client_id) || (request() != NULL && request()->client_id == $user->id ) || old('client_id') == $user->id) selected @endif>{{$user->name}} {{$user->lastName  }} </option>
            @endforeach
        </select>
        @error('client_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="col-md-6">
    <div class="form-group bmd-form-group">
        <select name="area_id" class="form-control @error('area_id') is-invalid @enderror">
            <option value="0">@lang('site.choose-area')</option>
            @foreach($areas as $area)
            <option value="{{$area->id}}" @if((isset($row) && $area->id== $row->area_id) || (request() != NULL && request()->area_id == $area->id ) || old('area_id') == $area->id) selected @endif>{{$area->name}}</option>
            @endforeach
        </select>
        @error('area_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>




    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.end_shoping_date')</label>
            <input type="date" name="end_shoping_date" value="{{ isset($row) ? date('Y-m-d', strtotime($row->end_shoping_date)) : old('end_shoping_date') }}"
                class="form-control @error('end_shoping_date') is-invalid @enderror">
            @error('end_shoping_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
        <div class="col-md-6">
            <div class="form-group bmd-form-group">
                <label class="bmd-label-floating">@lang('site.arrival_date')</label>
                <input type="date" name="arrival_date" value="{{ isset($row) ? date('Y-m-d', strtotime($row->arrival_date)) : old('arrival_date') }}"
                    class="form-control @error('arrival_date') is-invalid @enderror">
                @error('arrival_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group bmd-form-group">
                <label class="bmd-label-floating">@lang('site.feedback')</label>
                <input type="text" name="feedback" value="{{ isset($row) ? $row->feedback : old('feedback') }}"
                    class="form-control @error('feedback') is-invalid @enderror">
                @error('feedback')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
