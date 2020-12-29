{{csrf_field()}}
<div class="row">
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.firstName')</label>
            <input type="text" name="firstName" value="{{ isset($row) ? $row->firstName : old('firstName') }}"
                class="form-control @error('firstName') is-invalid @enderror">
            @error('firstName')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.lastName')</label>
            <input type="text" name="lastName" value="{{ isset($row) ? $row->lastName : old('lastName') }}"
                class="form-control @error('lastName') is-invalid @enderror">
            @error('lastName')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.email')</label>
            <input type="email" name="email" value="{{ isset($row) ? $row->email : old('email') }}"
                class="form-control @error('email') is-invalid @enderror">
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    @php
    $groupList = ['admin', 'delivery', 'emp', 'user'];
    @endphp
    

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.ssn')</label>
            <input type="number" name="ssn"  value="{{ isset($row) ? $row->ssn : old('ssn') }}"
                class="form-control @error('ssn') is-invalid @enderror">
            @error('ssn')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.salary')</label>
            <input type="number" name="salary"  value="{{ isset($row) ? $row->salary : old('salary') }}"
                class="form-control @error('salary') is-invalid @enderror">
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
            <input type="text" name="commission"  value="{{ isset($row) ? $row->commission : old('commission') }}"
                class="form-control @error('commission') is-invalid @enderror">
            @error('commission')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.phone')</label>
            <input type="text" name="phone" value="{{ isset($row) ? $row->phone : old('phone') }}"
                class="form-control @error('phone') is-invalid @enderror">
            @error('phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.password')</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.repeat_password')</label>
            <input type="password" name="c_password"
                class="form-control @error('password') is-invalid @enderror">
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.group')</label>
            <select name="group" class="form-control @error('group') is-invalid @enderror">
               <option value="...">@lang('site.choose-group')</option>
                @foreach ($groupList as $item)
                <option value="{{$item}}" {{isset($row) && $row->group == $item ? 'selected' : ''}}>{{$item}}</option>
                @endforeach
            </select>
            @error('group')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.gender')</label>

            <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                <option value="...">@lang('site.choose-gender')</option>
                <option value="1" {{isset($row) && $row->gender == '1' ? 'selected' : ''}}>@lang('site.male')</option>
                <option value="0" {{isset($row) && $row->gender == '0' ? 'selected' : ''}}>@lang('site.female')</option>
            </select>
            @error('gender')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.delivery_status')</label>

            <select name="delivery_status" class="form-control @error('delivery_status') is-invalid @enderror">
                <option value="...">@lang('site.choose-delivery_status')</option>
                <option value="0" {{isset($row) && $row->delivery_status == '0' ? 'selected' : ''}}>@lang('site.busy')</option>
                <option value="1" {{isset($row) && $row->delivery_status == '1' ? 'selected' : ''}}>@lang('site.active')</option>
                <option value="2" {{isset($row) && $row->delivery_status == '2' ? 'selected' : ''}}>@lang('site.notActive')</option>
                <option value="3" {{isset($row) && $row->delivery_status == '3' ? 'selected' : ''}}>@lang('site.black_list')</option>
                <option value="4" {{isset($row) && $row->delivery_status == '4' ? 'selected' : ''}}>@lang('site.out_status')</option>

            </select>
            @error('delivery_status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    {{--<div class="col-md-3">--}}
    {{--<div class="">--}}
    {{--<label>@lang('site.image')</label>--}}
    {{--<input type="file" name="image" class="form-control image @error('image') is-invalid @enderror">--}}
    {{--@error('image')--}}
    {{--<span class="invalid-feedback" role="alert">--}}
    {{--<strong>{{ $message }}</strong>--}}
    {{--</span>--}}
    {{--@enderror--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="col-md-3" width="90px" height="50px">--}}
    {{--<div class="">--}}
    {{--<img src="{{isset($row) ? asset('uploads/user_images/'. $row->image) : asset('uploads/user_images/default.png')}}"
    width="100px" height="60px" class="img-thumbnail img-preview">--}}
    {{--</div>--}}
    {{--</div>--}}
    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.area_id')</label>
            <select class="form-control" style="height: 38px" name="area_id">
                {{-- $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe"); --}}
                
                @foreach(App\Models\Area::get() as $area)
                <option value="{{$area->id}}">{{$area->name}}</option>
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
        <div class="">
            <label>@lang('site.image')</label>
            <input type="file" name="image" class="form-control image @error('image') is-invalid @enderror">
            @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6" width="100px" height="60px">
        <div class="">
            <img src="{{isset($row) ?  $row->image_path : asset('uploads/users_images/user.png')}}" width="100px"
                style="height: 100px" class="img-thumbnail img-preview">
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.adress')</label>
            <input type="text" name="adress" value="{{ isset($row) ? $row->adress : old('adress') }}"
                class="form-control @error('adress') is-invalid @enderror">
            @error('adress')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

</div>