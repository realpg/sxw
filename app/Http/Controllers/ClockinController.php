<?php

namespace App\Http\Controllers;


use App\Components\ClockinManager;
use App\Components\FinanceCreditManager;
use App\Components\MemberManager;
use App\Components\SystemManager;
use App\Models\FinanceCredit;
use Illuminate\Http\Request;

class ClockinController extends Controller
{
	public static function clockin(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, [])) {
			$ret = "签到成功";
			$clockins = ClockinManager::getByDate($data['userid'],date("Y-m-d"));
			if ($clockins->count() > 0) {
				return ApiResponse::makeResponse(false, "已有今日签到记录", ApiResponse::UNKNOW_ERROR);
			}
			$clockin = ClockinManager::createObject();
			$clockin = ClockinManager::setClockin($clockin, $data);
			$clockin->cridect = SystemManager::getById(10)->value;
			if (!CreditController::changeCredit(
				['userid' => $data['userid'], 'amount' => SystemManager::getById('10')->value,
					'reason' => '发布求购信息消耗积分', 'note' => '消耗积分'])) {
				return ApiResponse::makeResponse(false, "积分变更失败", ApiResponse::UNKNOW_ERROR);
			} else {
				$clockin->save();
			};
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function getHistory(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['date'])) {
			$ret =ClockinManager::getByDate($data['userid'],$data['date'], array_key_exists('days', $data) ? $data['days'] : 1);
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
}
