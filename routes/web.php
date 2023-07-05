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
Auth::routes();

Auth::routes(['register' => false]);


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});



Route::get('verify/resend', 'Auth\TwoFactorController@resend')->name('verify.resend');
Route::get('verify/cancel', 'Auth\TwoFactorController@cancellogin')->name('verify.cancellogin');
Route::resource('verify', 'Auth\TwoFactorController')->only(['index', 'store']);

Route::group([
    'middleware' => ['auth', 'twofactor']
], function () {
    // Route::resource('permissions', 'PermissionsController');
    // Route::resource('roles', 'RolesController');
    // Route::resource('users', 'UsersController');
    Route::get('{path}', 'HomeController@index');
});

