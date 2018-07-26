<?php

namespace App\Http\Controllers;


use App\Components\BuyDataManager;
use App\Components\BuyManager;
use App\Components\CommentManager;
use App\Components\MemberManager;
use App\Components\TestManager;
use App\Models\Comment;
use App\Models\Member;
use App\Models\Test;
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
//		return RankingController::createDailyRanking();
//		$rank=new SortContainer([],'cost_credit',10);
//		for($i=1;$i<=50;$i++){
//			$rank->push(['cost_credit'=>rand(1,1000)]);
//		}
//		$testdata=$rank->getArray();
		$data = $request->all();
		$testdata = $data;
		return $testdata;
//		return view('test');
	}
	
	public function create(Request $request)
	{
		$data=$request->all();
		
		$buy=BuyManager::createObject();
		$buy_data=BuyDataManager::createObject();
		
		$buy=BuyManager::setUserInfo($buy,1);
		$buy=BuyManager::setBuy($buy,$data);
		$buy->save();
		
		
		$buy_data=BuyDataManager::setBuyData($buy_data,$data);
		$buy_data->itemid=$buy->itemid;
		$buy_data->save();
		return [$buy.$buy_data];
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
		if (checkParam($data, [ 'itemid'])) {
			$ret="请求成功";
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
}
