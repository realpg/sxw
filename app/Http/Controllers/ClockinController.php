<?php

namespace App\Http\Controllers;


use App\Components\ClockinManager;
use App\Components\FinanceCreditManager;
use App\Components\MemberManager;
use App\Models\FinanceCredit;

class ClockinController extends Controller
{
	public static function clockin(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, [])) {
			$ret = "签到成功";
			$clockin=ClockinManager::getByDate(date("Y-m-d H:i:s"));
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function getHistory(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, [])) {
			$ret = "请求成功";
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
}
