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
Route::get('test', 'DemoController@test');
Route::get('create', 'DemoController@create');  //
Route::get('getAllMembers', 'DemoController@getAllMembers');
Route::get('newMember', 'DemoController@newMember');


Route::get('getOpenid', 'LoginController@getOpenid');
Route::post('user/login', 'LoginController@login');

Route::group(['middleware' => ['checkXCXToken']], function () {
	
	//供应
	Route::get('sell/getList', 'SellController@getList');//根据id获取供应内容
	Route::get('sell/getById', 'SellController@getById');//根据id获取供应内容
	Route::get('sell/getByCondition', 'SellController@getByCon');//根据条件获取供应内容
	Route::get('sell/edit', 'SellController@edit');//获得编辑所需信息
	Route::post('sell/edit', 'SellController@editPost');//编辑POST
	Route::post('sell/search', 'SellController@searchPost');//查询POST
	
	Route::get('buy/getList', 'BuyController@getList');//根据id获取求购内容
	Route::get('buy/getById', 'BuyController@getById');//根据id获取求购内容
	Route::get('buy/getByCondition', 'BuyController@getByCon');//根据条件获取求购内容
	Route::get('buy/edit', 'BuyController@edit');//获得编辑所需信息
	Route::post('buy/edit', 'BuyController@editPost');//编辑POST
	Route::post('buy/search', 'BuyController@searchPost');//查询POST
	
	Route::get('fjmy/getList', 'FJMYController@getList');//根据id获取纺机贸易内容
	Route::get('fjmy/getById', 'FJMYController@getById');//根据id获取纺机贸易内容
	Route::get('fjmy/getByCondition', 'FJMYController@getByCon');//根据条件获取纺机贸易内容
	Route::get('fjmy/edit', 'FJMYController@edit');//获得编辑所需信息
	Route::post('fjmy/edit', 'FJMYController@editPost');//编辑POST
	Route::post('fjmy/search', 'FJMYController@searchPost');//查询POST
	
	Route::post('comment', 'CommentController@comment');//评论
	Route::post('agree', 'CommentController@agree');//点赞
	Route::post('favorite', 'CommentController@favorite');//收藏
	Route::get('myFavorite', 'CommentController@myFavorite');//我的收藏
	
	Route::post('member/editInfo', 'CompanyController@edit');//升级为会员
//	Route::post('member/updateInfo', 'CompanyController@update');//升级为会员
	Route::get('member/editInfo', 'CompanyController@getEditInfo');
	Route::post('member/clockin', 'ClockinController@clockin');//签到
	Route::get('member/clockin/history', 'ClockinController@getHistory');//签到记录
	Route::get('member/message', 'MessageController@getMessage');//我的消息
	Route::get('member/message/getById', 'MessageController@getById');
	
	Route::get('bussinessCard', 'CompanyController@bussinessCard');//名片列表
	Route::get('ranking', 'RankingController@getRanking');//排行榜
	
	Route::get('article/getList', 'ArticleController@getList');//全部资讯
	Route::get('article/getById', 'ArticleController@getById');//根据id获取资讯内容
	Route::get('article/getByCondition', 'ArticleController@getByCon');//根据条件获取资讯内容
	
	Route::get('ad/getByPid', 'ADController@getByPid');//获得广告信息
	
	Route::post('uploadImage','UploadController@upload');
});