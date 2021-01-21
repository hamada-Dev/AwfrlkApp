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
            <label class="bmd-label-floating">@lang('site.user_name')</label>
            <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                <option value="">@lang('site.choose-user')</option>
                @foreach($users as $user)
                <option value="{{$user->id}}" @if((isset($row) && $row->user_id == $user->id) || (request() != NULL &&
                    request()->user_id == $user->id ) || old('user_id') == $user->id) selected @endif>{{$user->name}}
                    {{$user->lastName}}</option>
                @endforeach
            </select>
            @error('user_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.area')</label>
            <select name="area_id" class="form-control @error('area_id') is-invalid @enderror">
                <option value="">@lang('site.choose-area')</option>
                @foreach(\App\Models\Area::all() as $area)
                <option value="{{$area->id}}" @if((isset($row) && $row->area_id == $area->id) || (request() != NULL &&
                    request()->area_id == $area->id ) || old('area_id') == $area->id) selected @endif>{{$area->name}}
                </option>
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
            <label class="bmd-label-floating">@lang('site.discount')</label>
            <input type="text" name="discount" value="{{ isset($row) ? $row->discount : old('discount') }}"
                class="form-control @error('discount') is-invalid @enderror">
            @error('discount')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.end_date')</label>
            <input type="date" name="end_date"
                value="{{ isset($row) ?  date('Y-m-d', strtotime($row->end_date)) : old('end_date') }}"
                class="form-control @error('end_date') is-invalid @enderror">
            @error('end_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.confirm')</label>
            <select name="confirm" class="form-control @error('confirm') is-invalid @enderror">
                <option value="3">@lang("site.choose_confirm")</option>
                <option value="0" {{(isset($row) && $row->confirm == 0) || old('confirm') == 0 ? 'selected' : ''}}>
                    @lang('site.notValide')</option>
                <option value="1" {{(isset($row) && $row->confirm == 1) || old('confirm') == 1 ? 'selected' : ''}}>
                    @lang('site.valide') </option>
            </select>
            @error('confirm')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

</div>