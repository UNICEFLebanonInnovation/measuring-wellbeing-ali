<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['auth_api']], function () {
	Route::any('create-application','Api\ApplicationController@generateApplication');
	Route::any('save-pre-test-application','Api\ApplicationController@savePreTest');
	Route::any('submit-pre-test-application','Api\ApplicationController@submitPreTest');
	Route::any('save-post-test-application','Api\ApplicationController@savePostTest');
	Route::any('submit-post-test-application','Api\ApplicationController@submitPostTest');
	Route::any('get-application','Api\ApplicationController@getApplication');
	Route::any('pre-test-application','Api\ApplicationController@getPreTest')->name('pre-test-application');
	Route::any('post-test-application','Api\ApplicationController@getPostTest')->name('post-test-application');

	Route::any('view-application','Api\ApplicationController@viewApplication');

	Route::any('get-gouvernate','Api\LocationController@getGouvernate');
	Route::any('get-caza','Api\LocationController@getCaza');
	Route::any('get-area','Api\LocationController@getArea');
	Route::any('get-status','Api\LocationController@getStatus');
});

Route::any('login','Api\LoginController@login');
Route::any('logout','Api\LoginController@logout');
Route::any('get-all-locations','Api\LocationController@getAllLocation');

Route::any('forgot-password','Api\ForgotPasswordController@index');
