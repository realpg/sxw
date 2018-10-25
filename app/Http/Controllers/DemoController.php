<?php

namespace App\Http\Controllers;


use App\Components\BanWordManager;
use App\Components\BuyDataManager;
use App\Components\BuyManager;
use App\Components\CommentManager;
use App\Components\CompanyDataManager;
use App\Components\CompanyManager;
use App\Components\CompanyYWLBManager;
use App\Components\FJMYDataManager;
use App\Components\FJMYManager;
use App\Components\InfoManager;
use App\Components\MemberManager;
use App\Components\MobileMessageManager;
use App\Components\QRManager;
use App\Components\RankingManager;
use App\Components\SellDataManager;
use App\Components\SellManager;
use App\Components\SystemManager;
use App\Components\TestManager;
use App\Components\We7\We7CreditRecordManager;
use App\Components\We7\We7SyncManager;
use App\Components\We7\We7UserManager;
use App\Models\Comment;
use App\Models\Member;
use App\Models\System;
use App\Models\Test;
use App\Models\We7\We7CreditRecord;
use App\Models\We7\We7Sync;
use App\Models\XCXLog;
use Illuminate\Http\Request;
use App\Http\Controllers\RankingController;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

//use Maatwebsite\Excel\Facades\Excel;

class DemoController extends Controller
{
	
	//登录页面
	public function home()
	{
		return view('demo/home');
	}
	
	public static function test1(){
		return We7Controller::syncCreditRecordFromWe7();
	}
	
	public static function test2(){
		return We7Controller::syncCreditToWe7();
	}
	
	public function test(Request $request)
	{
//		We7Controller::syncCreditRecordFromWe7();
//		We7Controller::syncCreditToWe7();
//		dd(getimagesize('https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJO5fFcD8F2R7MVETYPT4r7ibQ85zdcxTu0LXrYRLvzcPgmedYO4eOD5Tu4YvoXZJwqov3CDwb54Jw/132'));
//		$data = $request->all();
//		$start=date('Ymd H:i:s');
//		$arr = [];
//		$users = MemberManager::getByCon(['groupid' => [6]],true);
//		foreach ($users as $user) {
//			array_push($arr, QRManager::refreshCardQRByUserid($user->userid));
//		}
//		$end=date('Ymd H:i:s');
//		return [$start.' -- '.$end,$arr,$users];

//		//每天清理信息
//		//每天生成搜索信息
//		$sells = SellManager::getList();
//		foreach ($sells as $sell) {
//			$user = MemberManager::getByUsername($sell->username);
//			if (!$user) {
//				$sell->delete();
//			} else {
//				if($sell->thumbs==''){
//					$sell->thumbs.=$sell->thumb;
//					$sell->thumbs=$sell->thumbs?($sell->thumbs.','.$sell->thumb1):$sell->thumbs;
//					$sell->thumbs=$sell->thumbs?($sell->thumbs.','.$sell->thumb2):$sell->thumbs;
//					$sell->save();
//				}
//
//				$searchInfo = SellManager::createSearchInfo($sell);
//				$searchInfo->save();
//
//				$infodata=SellDataManager::getById($sell->itemid);
//				InfoController::Info_Banword($sell,$infodata);
//			}
//		}
//		$buys = BuyManager::getList();
//		foreach ($buys as $buy) {
//			$user = MemberManager::getByUsername($buy->username);
//			if (!$user) {
//				$buy->delete();
//			} else {
//				if($buy->thumbs==''){
//					$buy->thumbs.=$buy->thumb;
//					$buy->thumbs=$buy->thumbs?($buy->thumbs.','.$buy->thumb1):$buy->thumbs;
//					$buy->thumbs=$buy->thumbs?($buy->thumbs.','.$buy->thumb2):$buy->thumbs;
//					$buy->save();
//				}
//				$searchInfo = BuyManager::createSearchInfo($buy);
//				$searchInfo->save();
//
//				$infodata=BuyDataManager::getById($buy->itemid);
//				InfoController::Info_Banword($buy,$infodata);
//			}
//		}
//		$fjmys = FJMYManager::getList();
//		foreach ($fjmys as $fjmy) {
//			$user = MemberManager::getByUsername($fjmy->username);
//			if (!$user) {
//				$fjmy->delete();
//			} else {
//				if($fjmy->thumbs==''){
//					$fjmy->thumbs.=$fjmy->thumb;
//					$fjmy->thumbs=$fjmy->thumbs?($fjmy->thumbs.','.$fjmy->thumb1):$fjmy->thumbs;
//					$fjmy->thumbs=$fjmy->thumbs?($fjmy->thumbs.','.$fjmy->thumb2):$fjmy->thumbs;
//					$fjmy->save();
//				}
//				$searchInfo = FJMYManager::createSearchInfo($fjmy);
//				$searchInfo->save();
//
//				$infodata=FJMYDataManager::getById($fjmy->itemid);
//				InfoController::Info_Banword($fjmy,$infodata);
//			}
//		}
//
//		return ApiResponse::makeResponse(true,111,ApiResponse::SUCCESS_CODE);
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
		$filepath=storage_path('logs/laravel.log');
		return response()->download($filepath);
//		$logs = XCXLog::orderBy('id', 'desc')->paginate('50');
//		return view('log.index', ['datas' => $logs]);
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
