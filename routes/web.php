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

Route::post('/api/admin/auth/login', 'Admin\Auth\LoginController@login');

Route::get('/api/admin/type/list', 'Admin\Type\ListController@data');
Route::post('/api/admin/type/create', 'Admin\Type\CreateController@create');
Route::post('/api/admin/type/detail', 'Admin\Type\DetailController@data');
Route::post('/api/admin/type/update', 'Admin\Type\UpdateController@update');
Route::post('/api/admin/type/location', '');

Route::get('/api/admin/location/first', 'Admin\Location\ListController@first');
Route::get('/api/admin/location/second', 'Admin\Location\ListController@second');
Route::post('/api/admin/location/create', 'Admin\Location\CreateController@create');
Route::post('/api/admin/location/detail', 'Admin\Location\DetailController@data');
Route::post('/api/admin/location/update', 'Admin\Location\UpdateController@update');
Route::post('/api/admin/location/allot', 'Admin\Location\AllotController@data');
Route::post('/api/admin/location/allot', 'Admin\Location\AllotController@allot');
