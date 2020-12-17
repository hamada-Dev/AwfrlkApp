{{csrf_field()}}
<div class="row">
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.name')</label>
            <input type="text" name="name" value="{{ isset($row) ? $row->name : old('name') }}" class="form-control  @error('name') is-invalid @enderror" disabled>
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.email')</label>
            <input type="email" name="email" value="{{ isset($row) ? $row->email : old('email') }}" class="form-control @error('email') is-invalid @enderror" disabled>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.message')</label>
            <textarea name="message" class="form-control" cols="30" rows="5" disabled>{{ isset($row) ? $row->message : old('message') }}</textarea>
            @error('message')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

<hr>

    <div class="col-md-12">
        <hr>
        <h4>@lang('site.replayMessage')</h4>
        <br>
        <form action="{{route('replayMessage', $row->id)}}" method="POST">
            {{csrf_field()}}
            <div class="form-group bmd-form-group">
                <label class="bmd-label-floating">@lang('site.message')</label>
                <textarea name="replayMessage" class="form-control @error('email') is-invalid @enderror" cols="30" rows="5" >{{old('replayMessage') }}</textarea>
                @error('replayMessage')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary pull-right">@lang('site.send') @lang('site.'.$module_name_singular)</button>
        </form>
    </div>

</div>
