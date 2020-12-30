{{csrf_field()}}
<div class="row">

    <div class="col-md-6">
            <div class="form-group bmd-form-group">
                <label class="bmd-label-floating">@lang('site.user_delivey')</label>
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
            <label class="bmd-label-floating">@lang('site.getmoney')</label>
            <input type="number" step='0.01' name="getmoney" value="{{ isset($row) ? $row->getmoney : old('getmoney') }}"
                class="form-control @error('getmoney') is-invalid @enderror">
            @error('getmoney')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.givemoney')</label>
            <input type="number" step='0.01' name="givemoney" value="{{ isset($row) ? $row->givemoney : old('givemoney') }}"
                class="form-control @error('givemoney') is-invalid @enderror">
            @error('givemoney')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    
</div>

    
