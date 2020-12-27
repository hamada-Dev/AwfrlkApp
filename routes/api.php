<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function () {

    Route::group(['middleware' => 'auth:api'], function () {

        Route::post('logout', 'RegisterController@logoutApi');

        // this group i can add all  route and controller for all client in my site 
        Route::group(['middleware' => 'userGroup'], function () {

            // category route   
            Route::get('/category', 'CategoriesController@allCategories'); //good

            // product route 
            Route::resource('product', 'ProductController'); //good

            // product route 
            Route::resource('order', 'OrderController');

            // all offer route 
            Route::resource('offer', 'OfferController');  //good

            // all area route 
            Route::resource('area', 'AreasController');  //good

            //  user route 
            Route::resource('user', 'UserController'); //good

            // user offer route 
            Route::resource('userOffer', 'UserOfferController'); //good
        });

        // route group for delivery
        Route::group(['middleware' => 'deliveryGroup'], function () {

            // delivery route 
            Route::resource('delivery', 'DeliveryController');

            // delivery order route 
            Route::resource('deliveryOrder', 'DeliveryOrderController');

            // delivery statua route 
            Route::resource('deliveryStatus', 'DeliveryStatusController');
        });


        // Route::get('/user', function (Request $request) {
        //     return $request->user();
        // });

        Route::get('email/resend', 'VerificationApiController@resend')->name('verificationapi.resend');
    }); // end of middleware

    // login and register
    // Route::group(['middleware' => 'guest:api'], function () {
    Route::post('/register', 'RegisterController@register');

    Route::post('/login', 'LoginController@login');
    // });


    Route::get('email/verify/{id}', 'VerificationApiController@verify')->name('verificationapi.verify');

    //forget password
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'ResetPasswordController@reset');
});//end of group
