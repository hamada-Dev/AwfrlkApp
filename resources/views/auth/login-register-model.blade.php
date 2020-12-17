@guest
    <script>
        openLoginModal();
    </script>
@endguest
{{--Login & Register --}}
<div class="modal fade login" id="loginModal">
    <div class="modal-dialog login animated">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Login with</h4>
            </div>
            <div class="modal-body">
                <div class="box">
                    <div class="content">
                        <div class="social">
                            <a class="circle github" href="#">
                                <i class="fa fa-github fa-fw"></i>
                            </a>
                            <a id="google_login" class="circle google" href="#">
                                <i class="fa fa-google-plus fa-fw"></i>
                            </a>
                            <a id="facebook_login" class="circle facebook" href="#">
                                <i class="fa fa-facebook fa-fw"></i>
                            </a>
                        </div>
                        <div class="division">
                            <div class="line l"></div>
                            <span>or</span>
                            <div class="line r"></div>
                        </div>
                        <div class="error"></div>
                        <div class="form loginBox">
                            <form method="POST" action="{{route('login')}}" accept-charset="UTF-8">
                                {{csrf_field()}}
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}"  autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    <script>
                                        openLoginModal();
                                    </script>
                                @endif

                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password"  name="password" >

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                        <script>
                                        openLoginModal();
                                        </script>
                                    </span>
                                @endif

                                <input class="btn btn-default btn-login" type="submit" value="Login">
                            </form>
                        </div>
                    </div>
                </div>
                {{--Register Form--}}
                <div class="box">
                    <div class="content registerBox" style="display:none;">
                        <div class="form">
                            <form method="POST" html="{:multipart=>true}" data-remote="true" action="{{route('register')}}" accept-charset="UTF-8">
                                {{csrf_field()}}

                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Full Name" value="{{ old('name') }}"  autofocus>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    <script>
                                        openRegisterModal();
                                    </script>
                                @endif

                                <input id="email" type="email" class="form-control @error('email_register') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email_register') }}"  autofocus>
                                @if ($errors->has('email_register'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email_register') }}</strong>
                                    </span>
                                    <script>
                                        openRegisterModal();
                                    </script>
                                @endif

                                <input id="password" class="form-control @error('password_register') is-invalid @enderror" type="password" placeholder="Password" name="password">
                                @if ($errors->has('password_register'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password_register') }}</strong>
                                    </span>
                                    <script>
                                        openRegisterModal();
                                    </script>
                                @endif
                                <input id="password_confirmation" class="form-control" type="password" placeholder="Repeat Password" name="password_confirmation">
                                <input class="btn btn-default btn-register" type="submit" value="Create account" name="commit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="forgot login-footer">
                            <span>Looking to
                                 <a href="javascript: showRegisterForm();">create an account</a>
                            ?</span>
                </div>
                <div class="forgot register-footer" style="display:none">
                    <span>Already have an account ?</span>
                    <a href="javascript: showLoginForm();">Login</a>
                </div>
            </div>
        </div>
    </div>
</div> {{--End of login & register Model--}}
