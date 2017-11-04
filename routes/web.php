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

Route::group(['prefix' => 'admin'], function () {
    Route::get('{path?}', 'Admin\IndexController@show')->where('path', '[\/\w\.-]*');
});

Route::group(['prefix' => 'api'], function () {

    Route::group(['prefix' => 'user', 'middleware' => 'user'], function () {

    });

    Route::post('admin/auth/login', 'Admin\Auth\LoginController@login')->middleware('guest');

    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

        Route::post('auth/logout', 'Admin\Auth\LogoutController@logout');

        Route::get('user/list', 'Admin\User\ListController@data');
        Route::post('user/create', 'Admin\User\CreateController@create');
        Route::get('user/detail/{id}', 'Admin\User\DetailController@data');
        Route::post('user/update', 'Admin\User\UpdateController@update');

        Route::get('type/list', 'Admin\Type\ListController@data');
        Route::post('type/create', 'Admin\Type\CreateController@create');
        Route::get('type/detail/{id}', 'Admin\Type\DetailController@data');
        Route::post('type/update', 'Admin\Type\UpdateController@update');
        Route::get('type/location/{id}', 'Admin\Type\LocationController@data');
        Route::post('type/location', 'Admin\Type\LocationController@allot');

        Route::get('location/first', 'Admin\Location\ListController@first');
        Route::get('location/second', 'Admin\Location\ListController@second');
        Route::post('location/create', 'Admin\Location\CreateController@create');
        Route::post('location/delete', 'Admin\Location\DeleteController@delete');
        Route::get('location/detail/{id}', 'Admin\Location\DetailController@data');

    });

});
