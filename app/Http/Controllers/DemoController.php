<?php

namespace App\Http\Controllers;


use App\Components\BuyDataManager;
use App\Components\BuyManager;
use App\Components\CommentManager;
use App\Components\MemberManager;
use App\Components\MobileMessageManager;
use App\Components\SystemManager;
use App\Components\TestManager;
use App\Models\Comment;
use App\Models\Member;
use App\Models\System;
use App\Models\Test;
use App\Models\XCXLog;
use Illuminate\Http\Request;
use App\Http\Controllers\RankingController;

class DemoController extends Controller
{
	
	//登录页面
	public function home()
	{
		return view('demo/home');
	}
	
	public function test(Request $request)
	{// 构造请求数据
		$url = "http://localhost/destoon/admin.php?file=login&forward=http%3A%2F%2Flocalhost%2Fdestoon%2Fadmin.php";
		$headers = self::createHeaders();
		$body = ['username' => 'admin', 'password' => 'Aa123456'];
		// 拼接字符串
		$fields_string = "";
		foreach ($body as $key => $value) {
			$fields_string .= $key . '=' . $value . '&';
		}
		rtrim($fields_string, '&');
		// 提交请求
		$con = curl_init();
		curl_setopt($con, CURLOPT_URL, $url);
		curl_setopt($con, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($con, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($con, CURLOPT_HEADER, 0);
		curl_setopt($con, CURLOPT_POST, 1);
		curl_setopt($con, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($con, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($con, CURLOPT_POSTFIELDS, $fields_string);
		$result = curl_exec($con);
		curl_close($con);
		echo "" . $result;
		
//			return ['result' => (strpos("success:081314385758971112", "success") == 0)];
	}
	
	// 创建请求头
	public static function createHeaders()
	{
		$headers = array('Content-type: ' . "application/x-www-form-urlencoded", 'Accept: ' . "application/x-www-form-urlenconded");
		return $headers;
	}
	
	public
	function log()
	{
		$logs = XCXLog::orderBy('id', 'desc')->paginate('50');
		return view('log.index', ['datas' => $logs]);
	}
	
	public
	function create(Request $request)
	{
		$data = $request->all();
		
		$buy = BuyManager::createObject();
		$buy_data = BuyDataManager::createObject();
		
		$buy = BuyManager::setUserInfo($buy, 1);
		$buy = BuyManager::setBuy($buy, $data);
		$buy->save();
		
		
		$buy_data = BuyDataManager::setBuyData($buy_data, $data);
		$buy_data->itemid = $buy->itemid;
		$buy_data->save();
		return [$buy . $buy_data];
	}
	
	public
	function getAllMembers()
	{
		$testdata = MemberManager::getList();
		return $testdata;
	}
	
	public
	function newMember()
	{
		$member = MemberManager::createObject();
		$member->save();
		return ApiResponse::makeResponse(true, $member, ApiResponse::SUCCESS_CODE);
	}
	
	public
	static function functionName(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['itemid'])) {
			$ret = "请求成功";
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
}
