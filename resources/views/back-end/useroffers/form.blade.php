{{csrf_field()}}
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.user_id')</label>
            <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                <option value="0">@lang('site.choose-user')</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}" @if((isset($row) && $row->user_id == $user->id) || (request() != NULL && request()->user_id == $user->id ) || old('user_id') == $user->id) selected @endif>{{$user->firstName}}</option>
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
            <label class="bmd-label-floating">@lang('site.offer_id')</label>
            <select name="offer_id" class="form-control @error('offer_id') is-invalid @enderror">
                <option value="0">@lang('site.choose_offer')</option>
                @foreach($offers as $offer)
                    <option value="{{$offer->id}}" @if((isset($row) && $row->offer_id == $offer->id) || (request() != NULL && request()->offer_id == $offer->id ) || old('offer_id') == $offer->id) selected @endif>{{$offer->id . "Number Of Day"}}</option>
                @endforeach
            </select>
            @error('offer_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>