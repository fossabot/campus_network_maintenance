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

Route::get('/', 'IndexController@index');

Route::group(['prefix' => 'user'], function () {

    Route::redirect('/', '/user/repair/list');

    Route::get('auth/logout', 'User\Auth\LogoutController@logout');

    Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function () {
        Route::get('login', 'User\Auth\LoginController@show');
        Route::post('login', 'User\Auth\LoginController@login');
    });

    Route::group(['prefix' => 'repair', 'middleware' => 'user'], function () {
        Route::get('list', 'User\Repair\ListController@show');
        Route::get('create', 'User\Repair\CreateController@show');
        Route::post('create', 'User\Repair\CreateController@create');
        Route::get('detail/{id}', 'User\Repair\DetailController@show');
        Route::post('update', 'User\Repair\UpdateController@update');
        Route::post('description', 'User\Repair\UpdateController@description');
    });

});

Route::group(['prefix' => 'admin'], function () {
    Route::get('{path?}', 'Admin\IndexController@show')->where('path', '[\/\w\.-]*');
});

Route::group(['prefix' => 'api'], function () {

    Route::post('admin/auth/login', 'Admin\Auth\LoginController@login')->middleware('guest');
    Route::post('admin/auth/logout', 'Admin\Auth\LogoutController@logout')->middleware('admin');

    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

        // 维修单
        Route::group(['prefix' => 'repair'], function () {
            Route::post('list', 'Admin\Repair\ListController@data');
            Route::post('create', 'Admin\Repair\CreateController@create');
            Route::get('detail/{id}', 'Admin\Repair\DetailController@data');
            Route::post('update', 'Admin\Repair\UpdateController@update');
            Route::post('change', 'Admin\Repair\ChangeController@change');
        });

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
            Route::get('location/{id}/full', 'Admin\Type\LocationController@fullData');
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
