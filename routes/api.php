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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//	return $request->user();
//});

////测试接口，随时删除
//Route::any('test', 'DemoController@test');
//Route::get('create', 'DemoController@create');  //
//Route::get('getAllMembers', 'DemoController@getAllMembers');
//Route::get('newMember', 'DemoController@newMember');


Route::post('revision_credit', 'We7Controller@revision_credit');
//Route::get('getXCXQR', 'LoginController@getXCXQR');

Route::get('getOpenid', 'LoginController@getOpenid');//获取openid  已废弃
Route::post('user/login', 'LoginController@login');//登录  已录入

Route::group(['middleware' => ['checkXCXToken']], function () {
	Route::get('getInviteQR', 'LoginController@getInviteQR');//获得邀请用二维码  已录入
	
	Route::get('info/getList','InfoController@getList' );//首页获取  已录入
	Route::get('info/getByUserid','InfoController@getInfoByUserid' );//根据userid获取
	Route::post('info/search','InfoController@search' );//首页获取
	
	//供应
	Route::get('sell/getList', 'SellController@getList');//获取所有供应信息  已录入
	Route::get('sell/getById', 'SellController@getById');//根据id获取供应内容  已录入
	Route::get('sell/getByCondition', 'SellController@getByCon');//根据条件获取供应内容  已录入
	Route::get('sell/edit', 'SellController@edit');//获得编辑所需信息  已录入
	Route::post('sell/edit', 'SellController@editPost');//编辑POST  已录入
	Route::post('sell/search', 'SellController@searchPost');//查询POST  已录入
	
	//求购
	Route::get('buy/getList', 'BuyController@getList');//获取求购列表  已录入
	Route::get('buy/getById', 'BuyController@getById');//根据id获取求购内容  已录入
	Route::get('buy/getByCondition', 'BuyController@getByCon');//根据条件获取求购内容  已录入
	Route::get('buy/edit', 'BuyController@edit');//获得编辑所需信息  已录入
	Route::post('buy/edit', 'BuyController@editPost');//编辑POST  已录入
	Route::post('buy/search', 'BuyController@searchPost');//查询POST  已录入
	
	Route::get('fjmy/getList', 'FJMYController@getList');//根据id获取纺机贸易内容
	Route::get('fjmy/getById', 'FJMYController@getById');//根据id获取纺机贸易内容
	Route::get('fjmy/getByCondition', 'FJMYController@getByCon');//根据条件获取纺机贸易内容
	Route::get('fjmy/edit', 'FJMYController@edit');//获得编辑所需信息
	Route::post('fjmy/edit', 'FJMYController@editPost');//编辑POST
	Route::post('fjmy/search', 'FJMYController@searchPost');//查询POST
	
	Route::post('comment', 'CommentController@comment');//评论  已录入
	Route::post('comment/reply', 'CommentController@reply');//评论回复  已录入
	Route::get('comment/mine', 'CommentController@MyComments');//我的评论  已录入
	Route::get('comment/tome', 'CommentController@CommentToMe');//评论我的  已录入
	Route::post('agree', 'CommentController@agree');//点赞  已录入
	Route::get('agreeStatus', 'CommentController@agreeStatus');//收藏  已录入
	Route::post('favorite', 'CommentController@favorite');//收藏  已录入
	Route::get('favoriteStatus', 'CommentController@favoriteStatus');//收藏状态  已录入
	Route::get('myFavorite', 'CommentController@myFavorite');//我的收藏  已录入
	
	Route::post('member/editInfo', 'CompanyController@edit');//编辑会员信息  已录入
	Route::get('member/editInfo', 'CompanyController@getEditInfo');//获得编辑会员信息所需内容  已录入
	Route::post('member/clockin', 'ClockinController@clockin');//签到  已录入
	Route::get('member/clockin/history', 'ClockinController@getHistory');//签到记录  已录入
	
	Route::get('member/message', 'MessageController@getMessage');//我的消息  已录入
	Route::get('member/message/getById', 'MessageController@getById');
	
	Route::post('member/sendVertifyCode', 'MessageController@sendVertifyCode');//发送验证码  已录入
	
	Route::get('businesscard', 'BussinessCardController@getList');//名片列表  已录入
	Route::post('businesscard/search', 'BussinessCardController@search');//名片列表
	Route::get('businesscard/getByYWLB', 'BussinessCardController@getByYWLB');//根据业务类别获得名片  已录入
	Route::get('businesscard/getYWLB', 'BussinessCardController@getYWLB');//业务类别  已录入
	Route::get('businesscard/getByUserid', 'BussinessCardController@getByUserid_get');//根据用户id获取名片信息  已录入
	Route::get('businesscard/getQRByUserid', 'BussinessCardController@getQRByUserid');//名片二维码
//	Route::get('businesscard/RefreshMyQR', 'BussinessCardController@RefreshMyQR');//名片二维码
	
	Route::get('ranking', 'RankingController@getRanking');//排行榜  已录入
	
	Route::get('article/getList', 'ArticleController@getList');//全部资讯  已录入
	Route::get('article/getById', 'ArticleController@getById');//根据id获取资讯内容  已录入
	Route::get('article/getByCondition', 'ArticleController@getByCon');//根据条件获取资讯内容  已录入
	
	Route::get('ad/getByPid', 'ADController@getByPid');//根据pid获得广告信息  已录入
	
	Route::post('uploadImage','UploadController@store');//上传图片接口，已录入
	
	Route::get('ad/selling', 'ADController@getSellingADs');//获得出售中的广告  已录入
	Route::post('ad/buy','ADController@buy');//购买广告位  已录入
	Route::get('ad/my','ADController@my');//我的广告位  已录入
	Route::post('ad/change','ADController@change');//变更广告位内容  已录入
	
	Route::get('myInvited', 'LoginController@myInvited');//我邀请的用户  已录入
	Route::post('user/invited', 'LoginController@invited');//用户接受邀请  已录入
	
	Route::get('system/getKeyValue', 'SystemController@api_getKeyValue');//获得系统关键变量
	
	Route::get('vip/selling', 'VIPController@getSelling');//获得广告信息  已录入
	Route::post('vip/buy', 'VIPController@buy');//获得广告信息  已录入
	Route::get('vip/timeto', 'VIPController@timeto');//获得广告信息  已录入
	Route::get('vip/my', 'VIPController@my');//获得广告信息  已录入
	
	Route::get('category/getByMid', 'CategoryController@getByMid');//根据mid获得分类  已录入
	
	Route::get('creidt/getRecord', 'CreditController@getRecord');//积分记录  已录入
	
});