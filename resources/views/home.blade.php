@extends('layouts.apppp')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                        You are logged in! go to home page : <a href="{{url('/')}}">Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection