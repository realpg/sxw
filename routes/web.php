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

Route::get('/', function () {
    return view('welcome');
});

Route::get('systemKeyValues', 'SystemController@systemKeyValues_get');//设置系统关键变量
Route::post('systemKeyValues', 'SystemController@systemKeyValues_post');//设置系统关键变量

Route::get('lljl', 'SystemController@xcx_lljl');//小程序浏览记录