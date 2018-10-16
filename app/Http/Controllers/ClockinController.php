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
			$user=MemberManager::getById($data['userid']);
			if ($user->groupid==5) {
				return ApiResponse::makeResponse(false, "完善信息后才能签到", ApiResponse::UNKNOW_ERROR);
			}
			$clockins = ClockinManager::getByDate($data['userid'], date("Y-m-d"));
			if ($clockins->count() > 0) {
				return ApiResponse::makeResponse(false, "今日已签到", ApiResponse::UNKNOW_ERROR);
			}
			$clockin = ClockinManager::createObject();
			$clockin = ClockinManager::setClockin($clockin, $data);
			$clockin->cridect = SystemManager::getById(10)->value;
			if (!CreditController::changeCredit(
				['userid' => $data['userid'], 'amount' => SystemManager::getById('10')->value,
					'reason' => '签到获得积分', 'note' => '积分'])) {
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
			$days = array_key_exists('days', $data) ? $data['days'] : 1;
			$ret = [];
			for ($i = 0; $i < $days; $i++) {
				$date = date("Y-m-d", strtotime("+" . $i . " day", strtotime($data['date'])));
				array_push($ret, ClockinManager::getByDate($data['userid'], $date)->first());
			}
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
}
