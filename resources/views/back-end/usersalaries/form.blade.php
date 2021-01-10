{{csrf_field()}}
<div class="row">
<div class="col-md-6">
    <div class="form-group bmd-form-group">
        <label class="bmd-label-floating">@lang('site.name')</label>

        @if(!isset($onlyuser))
            <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                <option value="0">@lang('site.choose-employee')</option>
                @foreach($users as $user)
                <option value="{{$user->id}}" @if((isset($row) && $user->id== $row->user_id) || (request() != NULL && request()->user_id == $user->id ) || old('user_id') == $user->id) selected @endif>{{$user->name}} {{$user->lastName  }} </option>
                @endforeach
            </select>
        @else
            <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                <option value="{{$onlyuser->id}}">{{$onlyuser->name}} {{$onlyuser->lastName  }} </option>
            </select>
        @endif
        @error('user_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
    
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.salary')</label>
            @if(isset($lastSalary))
            <input type="number" step='0.01' name="salary"  value="{{$lastSalary->salary}}"
                class="form-control @error('salary') is-invalid @enderror">
            @else
            <input type="number" step='0.01' name="salary"  value="{{ isset($row) ? $row->salary : old('salary') }}"
                class="form-control @error('salary') is-invalid @enderror">
            @endif    
           
            @error('salary')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.commission')</label>
            @if(!isset($lastSalary))
                <input type="text" name="commission"  value="{{ isset($row) ? $row->commission : old('commission') }}"
                    class="form-control @error('commission') is-invalid @enderror">
            @else
                <input type="text" name="commission"  value="{{ $lastSalary->commission }}"
                    class="form-control  @error('commission') is-invalid @enderror">
            @endif     
            @error('commission')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.moneyDay')</label>
            <input type="date" name="moneyDay" value="{{ isset($row) ? date('Y-m-d', strtotime($row->moneyDay)) : old('moneyDay') }}"
                class="form-control @error('moneyDay') is-invalid @enderror">
            @error('moneyDay')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>