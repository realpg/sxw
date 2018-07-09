<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('test', 'DemoController@test')->middleware('checkXCXToken'); //测试接口
Route::get('create', 'DemoController@create');  //
Route::get('getAllMembers', 'DemoController@getAllMembers');
Route::get('newMember', 'DemoController@newMember');

Route::get('getOpenid', 'LoginController@getOpenid');
Route::post('user/login', 'LoginController@login');
