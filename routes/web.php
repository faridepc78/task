<?php

use Illuminate\Support\Facades\Route;


/*START ADMIN*/

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth', 'check_admin', 'throttle:50,1'],
    'namespace' => 'App\Http\Controllers\Admin'], function () {

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('dashboard', 'DashboardController')->name('dashboard');

    Route::resource('users', 'UserController')->except('show');

    Route::get('lotteries/result','LotteryController@result')->name('lotteries.result');
    Route::resource('lotteries', 'LotteryController')->except(['show', 'edit', 'update']);

});

/*END ADMIN*/


/*START AUTH*/

Route::group(['prefix' => '/', 'middleware' => ['web', 'throttle:50,1'],
    'namespace' => 'App\Http\Controllers\Auth'], function () {

    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login')->name('login');

    Route::any('logout', 'LoginController@logout')->name('logout')->middleware('auth');
});

/*END AUTH*/


/*START SITE*/

Route::group(['prefix' => '/', 'middleware' => ['web'],
    'namespace' => 'App\Http\Controllers\Site'], function () {

    Route::get('/', 'MainController')->name('home');

});

/*END SITE*/
