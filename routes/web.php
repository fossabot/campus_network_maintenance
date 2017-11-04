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
    Route::post('admin/auth/logout', 'Admin\Auth\LogoutController@logout');

    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

        // 维修人员
        Route::group(['prefix' => 'user'], function () {
            Route::get('list', 'Admin\User\ListController@data');
            Route::post('create', 'Admin\User\CreateController@create');
            Route::get('detail/{id}', 'Admin\User\DetailController@data');
            Route::post('update', 'Admin\User\UpdateController@update');
        });

        // 维修分类
        Route::group(['prefix' => 'type'], function () {
            Route::get('list', 'Admin\Type\ListController@data');
            Route::post('create', 'Admin\Type\CreateController@create');
            Route::get('detail/{id}', 'Admin\Type\DetailController@data');
            Route::post('update', 'Admin\Type\UpdateController@update');
            Route::get('location/{id}', 'Admin\Type\LocationController@data');
            Route::post('location', 'Admin\Type\LocationController@allot');
        });

        // 维修地区
        Route::group(['prefix' => 'location'], function () {
            Route::get('first', 'Admin\Location\ListController@first');
            Route::get('second', 'Admin\Location\ListController@second');
            Route::post('create', 'Admin\Location\CreateController@create');
            Route::post('delete', 'Admin\Location\DeleteController@delete');
            Route::get('detail/{id}', 'Admin\Location\DetailController@data');
        });

        // 维修备件

    });

});
