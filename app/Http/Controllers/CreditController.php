<?php

namespace App\Http\Controllers;


use App\Components\FinanceCreditManager;
use App\Components\MemberManager;
use App\Models\FinanceCredit;

class CreditController extends Controller
{
	public static function changeCredit($data)
	{
		if (checkParam($data, ['userid', 'amount', 'reason', 'note'])) {
			$ret = "请求成功";
			$user = MemberManager::getById($data['userid']);
			if ($user->credit + $data['amount'] >= 0) {
				$user->credit += 1*$data['amount'];
			} else {
				return false;
			}
			$data['balance'] = $user->credit;
			
			$financeCredit = FinanceCreditManager::createObject();
			$financeCredit = FinanceCreditManager::setFinanceCredit($financeCredit, $data);
			$financeCredit->save();
			return true;
			
		} else {
			return false;
		}
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
