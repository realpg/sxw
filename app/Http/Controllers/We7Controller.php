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
use App\Models\Comment;
use App\Models\Member;
use App\Models\System;
use App\Models\Test;
use App\Models\XCXLog;
use Illuminate\Http\Request;
use App\Http\Controllers\RankingController;

class We7Controller extends Controller
{
	public static function revision_credit(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['records'])) {
			if (gettype($data['records']) == 'string')
				$records = json_decode($data['records']);
			else
				$records = $data['records'];
		
			foreach ($records as $record) {
				$user = MemberManager::getByCon(['wx_openId' => [$record->openId]], ['userid', 'asc'])->first();
				if(!$user){
					$record->result=false;
					continue;
				}
				$record->result=CreditController::changeCredit([
					'userid'=>$user->userid,
					'amount'=>$record->amount,
					'reason'=>'微擎:'.$record->reason,
					'note'=>'微擎改动时间：【'.$record->addtime."】"
				]);
//				array_push($ret, $user);
			}
			$ret = $records;
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
}
