<?php

namespace App\Http\Controllers;


use App\Components\FinanceCreditManager;
use App\Components\MemberManager;
use App\Models\FinanceCredit;
use Illuminate\Http\Request;

class CreditController extends Controller
{
	public static function changeCredit($data)
	{
		if (checkParam($data, ['userid', 'amount', 'reason', 'note'])) {
			$ret = "请求成功";
			$user = MemberManager::getById($data['userid']);
			if ($user->credit + $data['amount'] >= 0) {
				$user->credit += 1 * $data['amount'];
				$user->save();
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
	
	public static function getRecord(Request $request)
	{
		$data = $request->all();
		$user=MemberManager::getById($data['userid']);
		//检验参数
		$records = FinanceCreditManager::getByCon(['username' => [$user->username]], true, ['addtime', 'desc']);
		$ret = $records;
		
		return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
	}
	
}
