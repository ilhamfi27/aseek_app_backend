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

Route::prefix('v1')->group(function (){
    Route::post('login', 'api\v1\UserController@login');
    Route::post('register', 'api\v1\UserController@register');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::group(['prefix' => 'location'], function () {
            Route::post('store/', 'api\v1\LocationController@store');
        });
        Route::group(['prefix' => 'user'], function () {
            Route::get('profil/', 'api\v1\UserController@profile');
        });
        Route::group(['prefix' => 'wali_murid'], function () {
            Route::get('data_anak/', 'api\v1\ParentController@childData');
            Route::get('monitor_lokasi/', 'api\v1\ParentController@childLocation');
        });
        Route::group(['prefix' => 'sekolah'], function () {
            Route::get('semua_murid/', 'api\v1\TeacherController@showAllStudents');
        });
    });
});
