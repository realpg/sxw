<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/7/10
 * Time: 9:31
 */

namespace App\Http\Controllers;


use App\Components\ADManager;
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
						$ad->user= $user = MemberManager::getById($ad->userid);
						$ad->company=$company = CompanyManager::getById($user->userid);
						$ad->bussinessCard = CompanyManager::getBussinessCard($company);
						break;
					case 2:
						$ad->info=InfoManager::getByCon($ad->item_mid,['itemid'=>[$ad->item_id]])->first();
						break;
				}
			}
			$ret = $ads;
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
}