{{csrf_field()}}
<div class="row">

    <div class="col-md-6">
            <div class="form-group bmd-form-group">
                <label class="bmd-label-floating">@lang('site.user_name')</label>
                <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                    <option value="0">@lang('site.choose-user')</option>
                    @foreach($users as $user)
                    <option value="{{$user->id}}" @if((isset($row) && $row->user_id == $user->id) || (request() != NULL && request()->user_id == $user->id ) || old('user_id') == $user->id) selected @endif>{{$user->firstName}} {{$user->lastName}}</option>
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
            <label class="bmd-label-floating">@lang('site.confirm')</label>
            <select name="confirm" class="form-control @error('confirm') is-invalid @enderror">
                <option value="">@lang("site.choose_confirm")</option>
                <option value="1"  @if((isset($row) && $row->confirm==1)) selected @endif >@lang('site.valide')</option>
                <option value="0" @if((isset($row) && $row->confirm==0)) selected @endif>@lang('site.notValide')</option>
            </select>
            @error('confirm')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>

    
