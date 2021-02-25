<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

define('PAG_COUNT', 30);
date_default_timezone_set('Africa/Cairo');

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::get('/', function () {
            // return redirect('home.index');
            return redirect()->route('home.index');
        });

        Route::get('google', function () {
            return view('googleAuth');
        });

        Route::get('auth/{provider}', 'Auth\LoginController@redirectToGoogle');
        Route::get('auth/{provider}/callback/', 'Auth\LoginController@handleGoogleCallback');



        Route::namespace('BackEnd')->prefix('admin')->middleware('admin')->group(function () {

            // Route::get('/home', 'HomeController@index')->name('home.index');

            Route::get('/', 'HomeController@index')->name('home.index');

            //users
            Route::resource('users', 'UsersController')->except('show');

            //categories
            Route::resource('categories', 'CategoriesController')->except('show');

            //products
            Route::resource('products', 'ProductsController')->except('show');

            //products
            Route::resource('productupdates', 'ProductUpdatesController')->only(['index']);

            //offers
            Route::resource('offers', 'OffersController')->except('show');

            //areas
            Route::resource('areas', 'AreasController')->except('show');
            Route::get('AreaChildern/{parent_id}', "AreasController@childern")->name("areas.childern");
            //deliveryMoto
            Route::resource('deliverymotocycles', 'DeliveryMotocyclesController');
            //useroffers
            Route::resource('useroffers', 'UserOffersController')->except('show');
            //orders
            Route::resource('orders', 'OredersController')->except("show");
            //orders recycle 
            Route::post('order/trash', 'OredersController@orderTrash')->name("order.trash");
            //orderDetails
            Route::resource('orderdetails', 'OrderDetailsController');
            //to seperate the delivery
            Route::get('/showDelivey', 'UsersController@showDelivery')->name('users.delivery');
            Route::get('/showUser', 'UsersController@showUser')->name('users.usersShow');

            //delivery history status
            Route::get("deliveystatus/{delivery_id}", 'UsersController@statusDelivery')->name('users.deliverystatus');
            //add in black list
            Route::get("blacklist/{id}", 'UsersController@addBlacklist')->name('users.blacklist');
            //show black list
            Route::get("blacklist", 'UsersController@showBlacklist')->name('users.showblacklist');
            //promocodes
            Route::resource('promocodes', 'promocodesController')->except('show');
            //advances
            Route::resource('advances', 'advancesController')->except('show');

            Route::get('advancesdelivery/{delivery_id}/{created_at}/{id}', 'advancesController@countResetMoney')->name('advances.countreset');

            Route::resource('order/pending', 'PendingOrderController');


            Route::get('advances/{advance_id}', 'advancesController@countMoney')->name('advances.countmoney');
            Route::get('showReport', 'advancesController@showReport')->name('advances.counts');
            Route::post('showmoney', 'advancesController@countAllMoney')->name('advances.totalmoney');
            //usersalaries
            Route::resource('usersalaries', 'usersalaryController');

            //slider fo android
            Route::resource('sliders', 'SliderController');

            //analysis 
            Route::get('analysis', 'analysisController@index')->name('analysis');

            //chat 
            Route::get('chat', 'ChatController@index')->name('chat');
        });

        Auth::routes();

        Auth::routes(['verify' => true]);

        // Route::group(['prefix' => 'admin','namespace' => 'Auth'],function(){
        //     // Authentication Routes...
        //     Route::get('login', 'LoginController@showLoginForm')->name('login');
        //     Route::post('login', 'LoginController@login');
        //     Route::post('logout', 'LoginController@logout')->name('logout');

        //     // Password Reset Routes...
        //     Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        //     Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        //     Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.token');
        //     Route::post('password/reset', 'ResetPasswordController@reset');
        // });

        Route::get('/verify_phone', function () {
            return view('auth.verify_phone');
        })->name('verify_phone');

        Route::post('/verify_phone_code', 'Auth\VerificationController@verifyPhone')->name('verify_phone_code');

        Route::get('/home', function () {
            return view('home');
        })->name('home');
    }
);
