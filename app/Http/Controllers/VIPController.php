<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/8/8
 * Time: 16:14
 */

namespace App\Http\Controllers;


use App\Components\BuyManager;
use App\Components\FJMYManager;
use App\Components\MemberManager;
use App\Components\SellManager;
use App\Components\VIPManager;
use App\Components\VIPUserManager;
use Illuminate\Http\Request;

class VIPController
{
	public static function getSelling()
	{
		$vips = VIPManager::getList()->groupBy('vip');
		return ApiResponse::makeResponse(true, $vips, ApiResponse::SUCCESS_CODE);
	}
	
	public static function buy(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		//检验参数
		if (checkParam($data, ['id'])) {
			$vip = VIPManager::getById($data['id']);
			$vip_user = VIPUserManager::createObject();
			$vip_user_exist = VIPUserManager::getByCon(['userid' => $user->userid, 'status' => [3, 0]], false, ["totime", "desc"])->first();
			if ($vip_user_exist)
				$vip_user->fromtime = $vip_user_exist->totime;
			else
				$vip_user->fromtime = time();
			
			$vip_user = VIPUserManager::setVIPUserByUserAndVIP($vip_user, $user, $vip);
			if (!CreditController::changeCredit(
				['userid' => $data['userid'], 'amount' => -1 * $vip->amount,
					'reason' => '购买vip', 'note' => $vip->desc])) {
				return ApiResponse::makeResponse(false, "积分不足", ApiResponse::UNKNOW_ERROR);
			};
			$vip_user->save();
			self::setInfoVip($user->username, VIPUserManager::getUserVIPLevel($user->userid));
			$ret = "成功";
			$ret = $vip_user;
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function check()
	{
		$vip_users = VIPUserManager::getList()->groupBy("userid");
		foreach ($vip_users as $userid => $vip_user) {
			
			$vip = 0;
			$user = MemberManager::getById($userid);
			foreach ($vip_user as $vip_u) {
				if ($vip_u->fromtime <= time() && $vip_u->totime >= time()) {
					$vip_u->status = 3;
					$vip = $vip_u->vip;
				} else if ($vip_u->totime < time()) {
					$vip_u->status = 1;//过期
				} else {
					$vip_u->status = 0;//未开始
				}
				$vip_u->save();
			}
			self::setInfoVip($user->username, $vip);
		}
	}
	
	public static function setInfoVip($username, $vip)
	{
		$infos = BuyManager::getByCon(['username' => [$username]]);
		foreach ($infos as $info) {
			$info->vip = $vip;
			$info->save();
		}
		$infos = SellManager::getByCon(['username' => [$username]]);
		foreach ($infos as $info) {
			$info->vip = $vip;
			$info->save();
		}
		$infos = FJMYManager::getByCon(['username' => [$username]]);
		foreach ($infos as $info) {
			$info->vip = $vip;
			$info->save();
		}
	}
	
	public static function my(Request $request)
	{
		$data = $request->all();
		$ret = VIPUserManager::getUserVIPTime($data['userid']);
		return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
	}
	
}