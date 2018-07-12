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

//测试接口，随时删除
Route::get('test', 'DemoController@test')->middleware('checkXCXToken');
Route::get('create', 'DemoController@create');  //
Route::get('getAllMembers', 'DemoController@getAllMembers');
Route::get('newMember', 'DemoController@newMember');


Route::get('getOpenid', 'LoginController@getOpenid');
Route::post('user/login', 'LoginController@login');

Route::group(['middleware' => ['checkXCXToken']], function () {
	
	//求购
	Route::get('buy/getList', 'BuyController@getList');//根据id获取求购内容
	Route::get('buy/getById', 'BuyController@getById');//根据id获取求购内容
	Route::get('buy/edit', 'BuyController@edit');//获得编辑所需信息
	Route::post('buy/edit', 'BuyController@editPost');//编辑POST
	
	Route::post('comment', 'CommentController@comment');//评论
	Route::post('agree', 'CommentController@agree');//点赞
});