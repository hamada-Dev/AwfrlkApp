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

Route::group(['namespace'=> 'Api'], function (){

    Route::group(['middleware'=> 'auth:api'], function () {

        Route::post('logout','RegisterController@logoutApi');

        Route::get('/user', function (Request $request) { return $request->user();});

        Route::post('/login', 'UsersController@login');
        Route::get('/videos/{id}', 'VideosController@findVideo');

        //add to cart
        Route::post('/hotels/room/addToCart', 'HotelsController@addToCart');

        Route::post('/trip/addToCart', 'TripsController@addToCart');

        //get cart by type  'room' , 'program'
        Route::get('/carts/getCart/{cartType}', 'HotelsController@getCart');


        //delete from cart
        Route::delete('/profile/destroyRoom/{id}', 'ProfilesController@destroyRoom');

        Route::delete('/profile/destroyProgram/{id}', 'ProfilesController@destroyProgram');


        Route::get('/userBookings', 'ProfilesController@userBookings')->name('front.userBookings');


        //book room
        Route::post('/hotels/storeRoomBook', 'HotelsController@storeRoomBook');

        //program book
        Route::post('/trips/programBook', 'TripsController@programBook');

        Route::get('email/resend', 'VerificationApiController@resend')->name('verificationapi.resend');



    }); // end of middleware

    Route::get('email/verify/{id}', 'VerificationApiController@verify')->name('verificationapi.verify');

    //forget password
    Route::post('password/email', 'Api\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Api\ResetPasswordController@reset');


    Route::post('/register', 'RegisterController@register');

    Route::get('/videos', 'VideosController@allVideos');
    Route::get('/categories', 'CategoriesController@allCategories');

    //Messages in touch
    Route::post('/contact-us', 'ProfilesController@messageStore');
    Route::get('/contact-us', 'HomeController@contact');

    //hotels
    Route::post('/hotels', 'HotelsController@findHotel');
    Route::get('/hotels/{destination_id}', 'HotelsController@show');

    //room
    Route::get('/hotels/selectRooms/{id}/{dateto}/{datefrom}/{childCount}/{roomCount}', 'HotelsController@selectRoom');

    Route::post('/bookingsInfo', 'ProfilesController@bookingsInfo')->name('front.bookingsInfo');

    //destinations of hotels
    Route::get('/destinations', 'HotelsController@destinations');


    //trips
    Route::get('/trips/category/{id}', 'TripsController@category');
    Route::get('/trips/show/{id}', 'TripsController@showTrip');

    Route::post('/trips/show/findTrip', 'TripsController@findTrip');



});//end of group
