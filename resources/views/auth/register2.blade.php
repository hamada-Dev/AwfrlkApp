@extends('layouts.app')

@section('content')
    <body class="register-page sidebar-collapse">
    <div class="page-header" style="background-image: url('/assets/frontend/img/login-image.jpg');">
        <div class="filter"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 ml-auto mr-auto">
                    <div class="card card-register">
                        <h3 class="title mx-auto">Create a new account</h3>
                        <form class="register-form" action="{{route('register')}}" method="POST">
                            {{csrf_field()}}
                            <label>@lang('site.name')</label>
                            <input type="text" name="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" placeholder="@lang('site.name')">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <label>@lang('site.email')</label>
                            <input type="text" name="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror" placeholder="@lang('site.email')">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <label>@lang('site.password')</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="@lang('site.password')">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <label>@lang('site.repeat_password')</label>
                            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="@lang('site.repeat_password')">
                            <button class="btn btn-white btn-block btn-round">@lang('site.register')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer register-footer text-center">
            <h6>©
                <script>
                    document.write(new Date().getFullYear())
                </script>, made with <i class="fa fa-heart heart"></i> Ahmed Ali</h6>
        </div>
    </div>
@endsection
