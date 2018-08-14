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
	{
		$DT_URL = 'http://localhost/destoon/admin.php';
		$url = '?file=login&forward=' . urlencode($DT_URL);
		
		$response = $this->call('GET', $url);
		
		return $response;
		$this->assertEquals(200, $response->status());
		$body = [
			'username' => 'admin',
			'password' => 'Aa123456'
		];
		
		
		// 拼接字符串
		$fields_string = "";
		foreach ($body as $key => $value) {
			$fields_string .= $key . '=' . $value . '&';
		}
		rtrim($fields_string, '&');
		
		return header("location:".$url);
		$con = curl_init($url);
		curl_setopt($con, CURLOPT_POST, 1);
		curl_setopt($con, CURLOPT_POSTFIELDS, $fields_string);
		$result = curl_exec($con);
		curl_close($con);
		return $result;
	}
	
	public function log()
	{
		$logs = XCXLog::orderBy('id', 'desc')->paginate('50');
		return view('log.index', ['datas' => $logs]);
	}
	
	public function create(Request $request)
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
	
	public function getAllMembers()
	{
		$testdata = MemberManager::getList();
		return $testdata;
	}
	
	public function newMember()
	{
		$member = MemberManager::createObject();
		$member->save();
		return ApiResponse::makeResponse(true, $member, ApiResponse::SUCCESS_CODE);
	}
	
	public static function functionName(Request $request)
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
