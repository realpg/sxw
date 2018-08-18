<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/7/10
 * Time: 9:31
 */

namespace App\Http\Controllers;


use App\Components\ADManager;
use App\Components\ADPlaceManager;
use App\Components\CompanyManager;
use App\Components\InfoManager;
use App\Components\MemberManager;
use App\Components\TagManager;
use Illuminate\Http\Request;

class ADController extends Controller
{
	public static function getByPid(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['pid'])) {
			$ads = ADManager::getByCon(['xcx_pid' => [$data['pid']], 'status' => [3]]);
			foreach ($ads as $ad) {
				switch ($ad->type) {
					case 1:
						$ad->user = $user = MemberManager::getById($ad->userid);
						$ad->company = $company = CompanyManager::getById($user->userid);
						$ad->businesscard = BussinessCardController::getByUserid($company->userid);
						break;
					case 2:
						$ad->info = InfoManager::getByCon($ad->item_mid, ['itemid' => [$ad->item_id]])->first();
						$ad->info->tags = array_arrange(TagManager::getByCon(['tagid' => explode(',', $ad->info->tag)]));
						break;
				}
			}
			$ret = array_arrange($ads);
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function getSellingADs()
	{
		$adPlaces = ADPlaceManager::getList();
		foreach ($adPlaces as $place) {
			$place->sellingADs = array_arrange(ADManager::getByCon(['xcx_pid' => [$place->pid], 'onsell' => [1]]));
		}
		$ret = $adPlaces;
		return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
		
	}
	
	public static function buy(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		//检验参数
		if (checkParam($data, ['itemid', 'level'])) {
			$ret = "请求成功";
			$AD = ADManager::getById($data['itemid']);
			if (!$AD) {
				return ApiResponse::makeResponse(false, '未找到对应广告', ApiResponse::UNKNOW_ERROR);
			} elseif ($AD->onsell != '1') {
				return ApiResponse::makeResponse(false, '广告位暂不出售', ApiResponse::UNKNOW_ERROR);
			}
			switch ($data['level']) {
				case 0:
					$amount = $AD->amount0;
					$druation = $AD->druation0 / 86400;
					break;
				case 1:
					$amount = $AD->amount1;
					$druation = $AD->druation1 / 86400;
					break;
				case 2:
					$amount = $AD->amount2;
					$druation = $AD->druation2 / 86400;
					break;
				default:
					return ApiResponse::makeResponse(false, "参数错误", ApiResponse::INNER_ERROR);
					break;
			}
			if (CreditController::changeCredit([
				'userid' => $user->userid,
				'amount' => -$amount,
				'reason' => "购买广告位" . $AD->name . ",itemid:" . $AD->itemid,
				'note' => "购买广告位",
				'ranking' => 1])
			) {
				$AD->onsell = 0;
				$AD->save();
				$admins = MemberManager::getByCon(['admin' => ['1']]);
				foreach ($admins as $admin) {
					if (!MessageController::sendSystemMessage([
						'title' => "小程序广告位购买通知",
						'content' => "用户【" . $user->username . "(userid=" . $user->userid .
							")】刚刚购买了广告位【" . $AD->desc . ",itemid:" . $AD->itemid .
							"】" . $druation . "天，请尽快联系。电话号码:" . $user->mobile,
						'touser' => $admin->username
					]))
						return ApiResponse::makeResponse(true, "购买成功，请主动联系客服", ApiResponse::SUCCESS_CODE);;
				}
				
				
				return ApiResponse::makeResponse(true, "购买成功，请等待客服联系", ApiResponse::SUCCESS_CODE);
			} else {
				return ApiResponse::makeResponse(false, '扣除积分失败', ApiResponse::UNKNOW_ERROR);
			}
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
}