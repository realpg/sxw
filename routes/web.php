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

Route::get('memberUpdate', 'SystemController@memberUpdate');//用户更新信息审核
Route::post('memberUpdate', 'SystemController@memberUpdate_post');//用户更新信息审核

Route::get('tag', 'SystemController@tag');//标签
Route::get('tag_edit', 'SystemController@tag_edit_get');//标签编辑get
Route::post('tag_edit', 'SystemController@tag_edit_post');//标签编辑post

Route::get('thesauru', 'SystemController@thesauru');//搜索同义词
Route::get('thesauru_edit', 'SystemController@thesauru_edit_get');//同义词编辑get
Route::post('thesauru_edit', 'SystemController@thesauru_edit_post');//同义词编辑post