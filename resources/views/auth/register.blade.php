
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login V6</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('css/login-css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/login-css/main.css')}}">
    <!--===============================================================================================-->
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
</head>
<body>


    <div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-t-20 p-b-20">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <span class="login100-form-title p-b-10">
				
					</span>
                <div class="img-container">
                    <a href="{{route('frontend.welcome')}}"><img src="/assets/images/logo-off.png"></a>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group bmd-form-group">
                            <div class="wrap-input100 validate-input m-t-30 m-b-35" data-validate = "@lang('site.enter') @lang('site.firstName')">
                                <input class="input100" value="{{old('firstName')}}" type="text" name="firstName" autocomplete="off">
                                <span class="focus-input100" data-placeholder="@lang('site.firstName')"></span>
                                @error('firstName')
                                    <span class="invalid-feedback" role="alert">
                                        <p style="color: red">{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group bmd-form-group">
                            <div class="wrap-input100 validate-input m-t-30 m-b-35" data-validate = "@lang('site.enter') @lang('site.lastName')">
                                <input class="input100" value="{{old('lastName')}}" type="text" name="lastName" autocomplete="off">
                                <span class="focus-input100" data-placeholder="@lang('site.lastName')"></span>
                                @error('lastName')
                                <span class="invalid-feedback" role="alert">
                                        <p style="color: red">{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group bmd-form-group">
                            <div class="wrap-input100 validate-input m-t-30 m-b-35" data-validate = "@lang('site.gender')">
                                <select style="margin-top: 18px; height: 47px;" name="gender" class="form-control @error('gender') is-invalid @enderror">
                                    <option value="Male" {{request()->gender == 'Male' ? 'selected':''}}>Male</option>
                                    <option value="Female" {{request()->gender == 'Female' ? 'selected':''}}>Female</option>
                                </select>
                                @error('gender')
                                <span class="invalid-feedback" role="alert">
                                        <p style="color: red">{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group bmd-form-group">
                            <div class="wrap-input100 validate-input m-t-30 m-b-35" data-validate = "@lang('site.enter') @lang('site.phone')">
                                <input class="input100" value="{{old('phone')}}" type="text" name="phone" autocomplete="off">
                                <span class="focus-input100" data-placeholder="@lang('site.enter') @lang('site.phone') with country code "></span>
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                        <p style="color: red">{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                            <div class="wrap-input100 validate-input m-t-30 m-b-35" data-validate = "@lang('site.country')">
                               @include('partials.country')
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                            <div class="wrap-input100 validate-input m-t-30 m-b-35" data-validate = "@lang('site.enter') @lang('site.email')">
                                <input class="input100" value="{{old('email')}}" type="text" name="email" autocomplete="off">
                                <span class="focus-input100" data-placeholder="@lang('site.email')"></span>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <p style="color: red">{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group bmd-form-group">
                            <div class="wrap-input100 validate-input m-t-30 m-b-35" data-validate = "@lang('site.enter') @lang('site.password')">
                                <input class="input100" type="password" name="password" autocomplete="off">
                                <span class="focus-input100" data-placeholder="@lang('site.password')"></span>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <p style="color: red">{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group bmd-form-group">
                            <div class="wrap-input100 validate-input m-t-30 m-b-35" data-validate = "@lang('site.repeat_password')">
                                <input class="input100" type="password" name="password_confirmation" autocomplete="off">
                                <span class="focus-input100" data-placeholder="@lang('site.repeat_password')"></span>
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                        <p style="color: red">{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" type="submit" name="register">
                        @lang('site.register')
                    </button>
                </div>

                <ul class="login-more p-t-40">

                    <li>
							<span class="txt1">
								@lang('site.haveAccount')
							</span>

                        <a href="{{route('login')}}" class="txt2">
                            Sign In
                        </a>
                    </li>

                    <li>
							<span class="txt1">
								Go To Home Page
							</span>

                        <a href="{{route('frontend.welcome')}}" class="txt2">
                            Home
                        </a>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>


<!--===============================================================================================-->
<script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
<!--===============================================================================================-->
<!-- Bootstrap -->
<script src="{{ asset('js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('js/login-js/main.js')}}"></script>

</body>
</html>