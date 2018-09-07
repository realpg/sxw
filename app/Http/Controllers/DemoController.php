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
use App\Components\RankingManager;
use App\Components\SellManager;
use App\Components\SystemManager;
use App\Components\TestManager;
use App\Components\We7\We7CreditRecordManager;
use App\Components\We7\We7SyncManager;
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
		$records = We7CreditRecordManager::getByTime(0, time());
		foreach ($records as $record) {
			if (We7SyncManager::getByCon(['we7_itemid' => [$record->id]]))
				continue;
			else {
				$sync = We7SyncManager::createObject();
				$sync = We7SyncManager::syncFromWe7($sync, $records);
				if ($sync){
					$sync->save();
					$record->SYNC=true;
				}
			}
		}
		return $records;
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
