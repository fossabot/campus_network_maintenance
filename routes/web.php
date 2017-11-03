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
Route::post('/api/admin/type/update', 'Admin\Type\CreateController@create');
