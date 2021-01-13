{{csrf_field()}}
{{-- @php
$client_id = session()->has('client_id') ? session()->get('client_id') : '' ;
$feedback = session()->has('feedback') ? session()->get('feedback') : '';
@endphp --}}

<div class="row">

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.choose-deliver')</label>
            <select name="delivery_id" class="form-control @error('delivery_id') is-invalid @enderror">
                <option value="0">@lang('site.choose-deliver')</option>
                @foreach($delivers as $deliver)
                <option value="{{$deliver->id}}" @if((isset($row) && $deliver->id== $row->delivery_id) || (request() !=
                    NULL
                    && request()->delivery_id == $deliver->id ) || old('delivery_id') == $deliver->id) selected
                    @endif>{{$deliver->name}} {{$deliver->lastName  }} </option>
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
            <label class="bmd-label-floating">@lang('site.choose-client')</label>
            <select name="client_id" class="form-control @error('client_id') is-invalid @enderror">
                <option value="0">@lang('site.choose-client')</option>
                @foreach($users as $user)
                <option value="{{$user->id}}" @if((isset($row) && $user->id== $row->client_id) || (request() != NULL &&
                    request()->client_id == $user->id ) || old('client_id') == $user->id) || ($client_id == $user->id)
                    selected @endif>{{$user->name}}
                    {{$user->lastName  }} </option>
                @endforeach
            </select>
            @error('client_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.feedback')</label>
            <textarea name="feedback" rows="5" cols="10"
                class="form-control @error('feedback') is-invalid @enderror">{{ isset($row) ? $row->feedback : old('feedback') }}</textarea>
            @error('feedback')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    @php
    $orderType = ['0' => 'usual', '1' => 'fromto', '2' => 'pharmacy',]
    @endphp

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <select name="order_type" class="form-control @error('order_type') is-invalid @enderror" require='true'>
                <option value="..">@lang('site.choose-typeofordre')</option>
                @foreach ($orderType as $key=>$item)
                <option value="{{$key}}" {{$key == old('order_type') ? 'selected' : ''}}>@lang('site.'.$item)</option>
                @endforeach

            </select>
            @error('order_type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

</div>