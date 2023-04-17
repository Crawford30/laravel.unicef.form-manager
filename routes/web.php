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

Auth::routes();

Route::get('/login-from-platform', 'AuthController@loginFromPlatform');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout-from-platform', 'AuthController@logoutFromPlatform')->name("logout.platform");
    Route::get('/forms/collect-data/{id}', 'FormController@collectData')->name('use-form');
    Route::get('/help-center', 'HelpController@index')->name('help-center');

});

Route::get('/', 'HomeController@index')->name('/');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/forms/create', 'FormController@createForm');
Route::get('/forms/edit/{id}', 'FormController@editForm');

Route::get('/list-forms', 'FormController@showForms')->name('list-forms');
Route::get('/users-forms', 'FormController@userForms')->name('users-forms');
Route::get('/viewers-forms', 'FormController@viewerForms')->name('viewers-forms');
Route::get('/data-forms', 'FormController@collectedData')->name('data-forms');
Route::get('/data-forms/{id}', 'FormController@formCollectedData')->name('data-form');
Route::post('/data-forms/export', 'FormController@exportData')->name('data-form-export');

    Route::get('/mails', function () {
    	$exitcode = Artisan::call('MonthlyEmail:Report');
    	$exitcode = Artisan::call('DayOwn:Report');
    	$exitcode = Artisan::call('DayUse:Report');
    	});
