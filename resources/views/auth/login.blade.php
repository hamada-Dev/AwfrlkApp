
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
</head>
<body>
@guest()
    @else

    @endguest

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-t-20 p-b-20">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <span class="login100-form-title p-b-10">
				
					</span>
                <div class="img-container">
                    {{-- <a href="{{route('frontend.welcome')}}"><img src="/assets/images/logo-off.png"></a> --}}
                    <a href=""><img src="{{asset('assets/images/eg.jpg')}}"></a>
                </div>

                <div class="wrap-input100 validate-input m-t-30 m-b-35" data-validate = "Enter Email">
                    <input class="input100" type="text" name="email" autocomplete="off">
                    <span class="focus-input100" data-placeholder="Email"></span>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <p style="color: red">{{ $message }}</p>
                    </span>
                    @enderror
                </div>

                <div class="wrap-input100 validate-input m-b-30" data-validate="Enter password">
                    <input type="password" name="password" class="form-control input100 @error('password') is-invalid @enderror" autocomplete="off">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <p style="color: red">{{ $message }}</p>
                    </span>
                    @enderror
                    <span class="focus-input100" data-placeholder="Password"></span>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" type="submit" name="login">
                        Login
                    </button>
                </div>

                <ul class="login-more p-t-40">
                    {{--<li class="m-b-8">--}}
							{{--<span class="txt1">--}}
								{{--Forgot--}}
							{{--</span>--}}

                        {{--<a href="#" class="txt2">--}}
                            {{--Username / Password?--}}
                        {{--</a>--}}
                    {{--</li>--}}

                    <li>
							<span class="txt1">
								Don’t have an account? 
							</span>
                            <small style="color: red;">Admin have to add you</small>
                        {{-- <a href="{{route('register')}}" class="txt2">
                            Sign up
                        </a> --}}
                    </li>

                    <li>
							<span class="txt1">
								Forgot your password ?
							</span>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </li>
                    <li>
							<span class="txt1">
								Go To Home Page
							</span>

                        <a href="" class="txt2">
                        {{-- <a href="{{route('frontend.welcome')}}" class="txt2"> --}}
                            Home
                        </a>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>


<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
<script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
<!--===============================================================================================-->

<!--===============================================================================================-->
<script src="{{asset('js/login-js/main.js')}}"></script>

</body>
</html>