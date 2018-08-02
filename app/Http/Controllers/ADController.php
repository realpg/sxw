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
						$ad->bussinessCard = CompanyManager::getBussinessCard($company);
						break;
					case 2:
						$ad->info = InfoManager::getByCon($ad->item_mid, ['itemid' => [$ad->item_id]])->first();
						break;
				}
			}
			$ret = $ads;
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function getSellingADs()
	{
		$adPlaces = ADPlaceManager::getList();
		foreach ($adPlaces as $place) {
			$place->sellingADs = ADManager::getByCon(['xcx_pid' => [$place->pid], 'onsell' => [1]]);
		}
		$ret = $adPlaces;
		return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
		
	}
	
	public static function buy(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		//检验参数
		if (checkParam($data, ['itemid'])) {
			$ret = "请求成功";
			$AD = ADManager::getById($data['itemid']);
			if (!$AD) {
				return ApiResponse::makeResponse(false, '未找到对应广告', ApiResponse::UNKNOW_ERROR);
			} elseif ($AD->onsell != '1') {
				return ApiResponse::makeResponse(false, '广告位暂不出售', ApiResponse::UNKNOW_ERROR);
			}
			if (CreditController::changeCredit([
				'userid' => $user->userid,
				'amount' => -$AD->amount,
				'reason' => "购买广告位" . $AD->name . ",itemid:" . $AD->itemid,
				'note' => "购买广告位",
				'ranking' => 1])
			) {
				$admins = MemberManager::getByCon(['admin' => ['1']]);
				foreach ($admins as $admin) {
					if (!MessageController::sendSystemMessage([
						'title' => "小程序广告位购买通知",
						'content' => "用户【" . $user->username . "(userid=" . $user->userid .
							")】刚刚购买了广告位【" . $AD->desc . ",itemid:" . $AD->itemid .
							"】，请尽快联系。电话号码:" . $user->mobile,
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