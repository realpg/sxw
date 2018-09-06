<?php

namespace App\Http\Controllers;


use App\Components\BuyDataManager;
use App\Components\BuyManager;
use App\Components\CommentManager;
use App\Components\CompanyDataManager;
use App\Components\CompanyManager;
use App\Components\FJMYManager;
use App\Components\InfoManager;
use App\Components\MemberManager;
use App\Components\MobileMessageManager;
use App\Components\SellManager;
use App\Components\SystemManager;
use App\Components\TestManager;
use App\Components\We7CreditManager;
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
		$arr=[];
		//每天清理信息
		//每天生成搜索信息
		$sells = SellManager::getList();
		$arr['sell']=[];
		foreach ($sells as $sell) {
			$value=['itemid'=>$sell->itemid];
			$user = MemberManager::getByUsername($sell->username);
			if (!$user) {
				$sell->delete();
				$value['delete']=true;
			} else {
				$searchInfo = SellManager::createSearchInfo($sell);
				$searchInfo->save();
			}
			array_push($arr['sell'],$value);
		}
		$buys = BuyManager::getList();
		$arr['buy']=[];
		foreach ($buys as $buy) {
			$value=['itemid'=>$buy->itemid];
			$user = MemberManager::getByUsername($buy->username);
			if (!$user) {
				$buy->delete();
				$value['delete']=true;
			} else {
				$searchInfo = BuyManager::createSearchInfo($buy);
				$searchInfo->save();
			}
			array_push($arr['buy'],$value);
		}
		$fjmys = FJMYManager::getList();
		$arr['fjmy']=[];
		foreach ($fjmys as $fjmy) {
			$value=['itemid'=>$fjmy->itemid];
			$user = MemberManager::getByUsername($fjmy->username);
			if (!$user) {
				$fjmy->delete();
				$value['delete']=true;
			} else {
				$searchInfo = FJMYManager::createSearchInfo($fjmy);
				$searchInfo->save();
			}
			array_push($arr['fjmy'],$value);
		}
		return $arr;
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
