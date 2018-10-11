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
use App\Components\We7\We7CreditRecordManager;
use App\Components\We7\We7MemberManager;
use App\Components\We7\We7SyncManager;
use App\Models\Comment;
use App\Models\Member;
use App\Models\System;
use App\Models\Test;
use App\Models\We7\We7Sync;
use App\Models\We7\We7User;
use App\Models\XCXLog;
use Illuminate\Http\Request;
use App\Http\Controllers\RankingController;
use Illuminate\Support\Facades\Log;

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
				if (!$user) {
					$record->result = false;
					continue;
				}
				$record->result = CreditController::changeCredit([
					'userid' => $user->userid,
					'amount' => $record->amount,
					'reason' => '微擎:' . $record->reason,
					'note' => '微擎改动时间：【' . $record->addtime . "】"
				]);
//				array_push($ret, $user);
			}
			$ret = $records;
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function syncCreditRecordFromWe7()
	{
		$records = We7CreditRecordManager::getByTime(We7SyncManager::lastSyncTime(), time());
		foreach ($records as $record) {
			if (We7SyncManager::getByCon(['we7_itemid' => [$record->id]])->first()) {
				$record->exist = true;
				$record->record = We7SyncManager::getByCon(['we7_itemid' => [$record->id]]);
				continue;
				
			} elseif ((int)$record->num == 0) {
				continue;
			} else {
				$sync = We7SyncManager::createObject();
				$sync = We7SyncManager::syncFromWe7($sync, $record);
				if ($sync) {
					$sync->save();
					$record->sync = true;
				}
			}
		}
		return ApiResponse::makeResponse(true, $records, ApiResponse::SUCCESS_CODE);
	}
	
	public static function syncCreditToWe7($xcx_users = null)
	{
		$ARR = [];
		if (!$xcx_users)
			$xcx_users = MemberManager::getXCXMembers();
		foreach ($xcx_users as $user) {
			$we7member = We7MemberManager::getByOpenid($user->wx_openId);
			if (!$we7member) {
				continue;
			}
			
			if ((int)abs($user->credit - $we7member->credit1) >= 1) {//同步积分)
				Log::info('改变积分【' . $user->userid . '】:'
					. (int)($user->credit - $we7member->credit1));
				$we7member->credit1 = $user->credit;//同步积分
				
				$we7record = We7CreditRecordManager::createObject();//创建积分记录
				$we7record->num = $user->credit - $we7member->credit1;
				$we7record->save();
				
				//创建同步记录
				$sync = We7SyncManager::createObject();
				$sync->we7_itemid = $we7record->id;
				$sync->dt_itemid = '';
				$sync->stream = 1;
				$sync->time = time();
				$sync->save();
				
				$we7member->save();
				
				array_push($ARR, [$user, $we7member, $we7record, $sync]);
			}
			
		}
		return $ARR;
	}
	
}
