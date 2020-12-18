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
            Route::get('/category', 'CategoriesController@allCategories');

            // product route 
            Route::resource('product', 'ProductController');

            // product route 
            Route::resource('order', 'OrderController');
        });

        // route group for delivery
        Route::group(['middleware' => 'deliveryGroup'], function () {
        });


        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('/login', 'UsersController@login');




        Route::get('email/resend', 'VerificationApiController@resend')->name('verificationapi.resend');
    }); // end of middleware

    Route::get('email/verify/{id}', 'VerificationApiController@verify')->name('verificationapi.verify');

    //forget password
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'ResetPasswordController@reset');


    Route::post('/register', 'RegisterController@register');

    // Route::get('/videos', 'VideosController@allVideos');
    // Route::get('/categories', 'CategoriesController@allCategories');

    //Messages in touch
    // Route::post('/contact-us', 'ProfilesController@messageStore');
    // Route::get('/contact-us', 'HomeController@contact');

    //hotels
    // Route::post('/hotels', 'HotelsController@findHotel');
    // Route::get('/hotels/{destination_id}', 'HotelsController@show');

    // //room
    // Route::get('/hotels/selectRooms/{id}/{dateto}/{datefrom}/{childCount}/{roomCount}', 'HotelsController@selectRoom');

    // Route::post('/bookingsInfo', 'ProfilesController@bookingsInfo')->name('front.bookingsInfo');

    // //destinations of hotels
    // Route::get('/destinations', 'HotelsController@destinations');


    //trips
    // Route::get('/trips/category/{id}', 'TripsController@category');
    // Route::get('/trips/show/{id}', 'TripsController@showTrip');

    // Route::post('/trips/show/findTrip', 'TripsController@findTrip');



});//end of group
