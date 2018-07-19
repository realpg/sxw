<?php

namespace App\Http\Controllers;


use App\Components\CompanyManager;
use App\Components\MemberManager;
use App\Components\UpgradeManager;
use Illuminate\Http\Request;


class CompanyController extends Controller
{
	public static function edit(Request $request){
		$data = $request->all();
		$user=MemberManager::getById($data['userid']);
		if($user->groupid==5){
			return self::upgrade($request);
		}else if($user->groupid==6){
			return self::update($request);
		}
		else{
			return ApiResponse::makeResponse(false, "暂不支持", ApiResponse::UNKNOW_ERROR);
		}
	}
	private static function upgrade(Request $request)
	{
		$data = $request->all();
		$user=MemberManager::getById($data['userid']);
		//检验参数
		if (checkParam($data, ['truename','company', 'career', 'business', 'address', 'sell', 'introduce'])) {
			
			$company=CompanyManager::getById($user->userid);
			$user=MemberManager::setMember($user,$data);
			$company=CompanyManager::setCompany($company,$data,$user);
			
			$upgrade=UpgradeManager::createObject();
			$upgrade=UpgradeManager::setUpgrade($upgrade,$user);
//			$user->groupid=6;
			$upgrade->groupid=6;
			$upgrade->groupid=6;
			
			$user->save();
			$company->save();
			$upgrade->save();
			
			$ret = [$user,$company,$upgrade];
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数".array_keys($data), ApiResponse::MISSING_PARAM);
		}
	}
	private static function update(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data,  ['truename','company', 'career', 'business', 'address', 'sell', 'introduce'])) {
			$ret="请求成功";
			
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
}
