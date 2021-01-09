{{csrf_field()}}
<div class="row">
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.user_license')</label>
            <input type="text" name="user_license" value="{{ isset($row) ? $row->user_license : old('user_license') }}"
                class="form-control @error('user_license') is-invalid @enderror">
            @error('user_license')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.moto_license')</label>
            <input type="text" name="moto_license" value="{{ isset($row) ? $row->moto_license : old('moto_license') }}"
                class="form-control @error('moto_license') is-invalid @enderror">
            @error('moto_license')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.moto_number')</label>
            <input type="text" name="moto_number" value="{{ isset($row) ? $row->moto_number : old('moto_number') }}"
                class="form-control @error('user_license') is-invalid @enderror">
            @error('moto_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.license_renew_date')</label>
            <input type="date" name="license_renew_date"
                value="{{ isset($row) ? date('Y-m-d', strtotime($row->license_renew_date)) : old('license_renew_date') }}"
                class="form-control @error('license_renew_date') is-invalid @enderror">
            @error('license_renew_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.license_expire_date')</label>
            <input type="date" name="license_expire_date"
                value="{{ isset($row) ? date('Y-m-d', strtotime($row->license_expire_date)) : old('license_expire_date') }}"
                class="form-control @error('license_expire_date') is-invalid @enderror">
            @error('license_expire_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.type')</label>
            <input type="text" name="type" value="{{ isset($row) ? $row->type : old('type') }}"
                class="form-control @error('type') is-invalid @enderror">
            @error('type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.color')</label>
            <input type="text" name="color" value="{{ isset($row) ? $row->color : old('color') }}"
                class="form-control @error('color') is-invalid @enderror">
            @error('color')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.user_id')</label>
            <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                @if(!isset($user))
                <option value="0">@lang('site.choose-user')</option>
                @foreach($users as $user)
                <option value="{{$user->id}}" @if((isset($row) && $row->user_id == $user->id)|| (request()->dID == $user->id ) || old('user_id') == $user->id) selected @endif>{{$user->name}}
                </option>
                @endforeach
                @else
                <option value="{{$user->id}}">{{$user->name}}{{$user->lastName}}</option>
                @endif
            </select>
            @error('user_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

</div>