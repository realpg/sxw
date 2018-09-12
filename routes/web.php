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

Route::get('log', 'DemoController@log');
Route::get('test', 'DemoController@test');

Route::group(['middleware' => ['checkAdmin']], function () {
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
	
	Route::get('rebind', 'SystemController@rebind');//重绑小程序 废弃
	Route::post('rebind', 'SystemController@rebind_post');//重绑小程序 废弃
	Route::get('getUserByUserid', 'SystemController@getUserByUserid');//重绑小程序  废弃
	
	Route::get('ywlb', 'SystemController@ywlb');//业务类别
	Route::get('ywlb_edit', 'SystemController@ywlb_edit_get');//业务类别编辑get
	Route::post('ywlb_edit', 'SystemController@ywlb_edit_post');//业务类别编辑post
	
	Route::post('upload', 'UploadController@store');//上传
	
	Route::get('adplace', 'SystemController@adplace');//业务类别
	Route::get('adplace_edit', 'SystemController@adplace_edit');//业务类别
	Route::post('adplace_edit', 'SystemController@adplace_edit_post');//业务类别
	
	Route::get('ads', 'SystemController@ads');//广告
	Route::get('ads_edit', 'SystemController@ads_edit');//广告
	Route::post('ads_edit', 'SystemController@ads_edit_post');//广告
	Route::get('ads/record', 'SystemController@ads_record');//广告
	Route::post('ads/record', 'SystemController@ads_record_post');//广告
	
	Route::get('vip', 'SystemController@vip');//广告
	Route::get('vip_edit', 'SystemController@vip_edit');//广告
	Route::post('vip_edit', 'SystemController@vip_edit_post');//广告
	Route::get('vip/record', 'SystemController@vip_record');//广告
	
	Route::get('member', 'SystemController@member_index');//用户列表
	Route::get('member/index', 'SystemController@member_index');//用户列表
	Route::get('member/detail', 'SystemController@member_detail');//用户详情
	Route::get('member/edit', 'SystemController@member_edit');//用户列表
	Route::post('member/edit', 'SystemController@member_edit_post');//用户列表
});

Route::post('UploadExcel', 'FileReaderController@UploadExcel');//上传