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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api', 'middleware' => 'return-json'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', 'AuthController@login');
        Route::post('/login-token', 'AuthController@loginWithToken');
    });

    Route::group(['prefix' => 'form', 'middleware' => ['auth:api']], function () {
        Route::get('/list', 'FormController@getForms');
        Route::get('/list-staff', 'FormController@getStaff');
        Route::post('/create-form', 'FormController@createForm');
        Route::post('/serialized-form', 'FormController@getSerializedForm');
        Route::post('/serialized-data', 'FormController@getSerializedData');
        Route::post('/save-form-data', 'FormController@saveFormData');
        Route::post('/delete-form', 'FormController@deleteUserForm');
        Route::get('/details/{id}', 'FormController@getFormDetails');
        Route::get('/data/stats', 'FormController@getCollectedDataStats');
        Route::get('/data-form/stats/{id}', 'FormController@getCollectedDataFormStats');
    });

    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/form-data', 'DashboardController@getFormData');
    });
});
