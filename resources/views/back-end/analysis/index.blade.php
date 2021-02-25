@extends('back-end.layout.app')

@section('title')
@lang('site.analysis')
@endsection

@section('content')
@component('back-end.layout.nav-bar')

@slot('nav_title')
@lang('site.analysis')
@endslot
@endcomponent

<div class="container-fluid">

    <div class="row">
        <section class="home-stats" style="width: 100%">
            <div class="col-md-4 col-xs-6">
                <div class="stat st-members">
                    <i class="fa fa-users"></i>
                    <div class="info">
                        @lang('site.mostDelivery')
                        <span><a href="#">
                                55
                            </a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-6">
                <div class="stat st-pending">
                    <i class="fa fa-user-plus"></i>
                    <div class="info">
                        @lang('site.mostUser')
                        <span><a href="#">
                                666
                            </a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-6">
                <div class="stat st-items">
                    <i class="fa fa-tag"></i>
                    <div class="info">
                        @lang('site.mostProduct')
                        <span><a href="#">
                                77777
                            </a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-6">
                <div class="stat st-commnets">
                    <i class="fa fa-comment"></i>
                    <div class="info">
                        @lang('site.mostCategory')
                        <span>
                            <a href="#">

                                88888
                            </a>
                        </span>
                    </div>
                </div>
            </div>

        </section>
    </div>
</div>
<style>
    .home-stats .stat {
        padding: 20px;
        margin: 20px;
        font-size: 15px;
        color: #fff;
        border-radius: 10px;
        box-shadow: 4px 4px 10px #c29c9c;
        position: relative;
        overflow: hidden;
        transition: all 1s ease-in-out;
    }

    .home-stats .stat:hover {
        transform: scale(1.1, 1.1);
    }

    .home-stats .stat i {
        font-size: 75px;
        top: 60px;
        position: absolute;
        left: 30px;
    }

    .home-stats .stat .info {
        float: right;
        font-size: 30px;
    }

    .home-stats .stat a {
        color: #fff;
    }

    .home-stats .stat a:hover {
        text-decoration: none;
        transform: scale(1.5, 1.7);
        color: rgb(139, 0, 132);
    }

    .home-stats .stat a {
        transition: all 1s ease-in-out;
    }


    .home-stats .stat span,
    .home-stats .stat a {
        display: block;
        font-size: 60px;
    }

    .home-stats .st-members {
        background-color: #3498db;
    }


    .home-stats .st-pending {
        background-color: #c0392b;
    }

    .home-stats .st-items {
        background-color: #d35400;
    }

    .home-stats .st-commnets {
        background-color: #8e44ad;
    }
</style>
@endsection