<?php

namespace App\Http\Controllers;

use App\Components\AgreeManager;
use App\Components\BanWordManager;
use App\Components\FavoriteManager;
use App\Components\InfoManager;
use App\Components\MemberManager;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/8/18
 * Time: 20:18
 */
class InfoController extends Controller
{
	function getList(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		$page = array_get($request->all(), 'page') ? array_get($data, 'page') : 1;
		$infos = InfoManager::getByPage($page, 5);
		foreach ($infos['data'] as $info) {
			$info->I_agree = AgreeManager::getByCon(
				['item_mid' => [$info->mid],
					'item_id' => [$info->itemid],
					'username' => [$user->username]
				])->first() ? true : false;
			$info->I_favortie = FavoriteManager::getByCon(
				['mid' => [$info->mid],
					'tid' => [$info->itemid],
					'userid' => [$user->userid]
				]
			)->first() ? true : false;
		}
		return ApiResponse::makeResponse(true, $infos, ApiResponse::SUCCESS_CODE);
	}
	
	public static function getInfoByUserid(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		//检验参数
		if (checkParam($data, ['item_userid'])) {
			$itemuser = MemberManager::getById($data['item_userid']);
			$page = array_get($request->all(), 'page') ? array_get($data, 'page') : 1;
			$infos = InfoManager::getByUsernameAndPage($itemuser->username, $page, 5);
			foreach ($infos['data'] as $info) {
				$info->I_agree = AgreeManager::getByCon(
					['item_mid' => [$info->mid],
						'item_id' => [$info->itemid],
						'username' => [$user->username]
					])->first() ? true : false;
				$info->I_favortie = FavoriteManager::getByCon(
					['mid' => [$info->mid],
						'tid' => [$info->itemid],
						'userid' => [$user->userid]
					]
				)->first() ? true : false;
			}
			
			return ApiResponse::makeResponse(true, $infos, ApiResponse::SUCCESS_CODE);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function search(Request $request)
	{
		$data = $request->all();
		if (checkParam($data, ['keyword'])) {
			$cards = BussinessCardController::search($request, false);
			$sells = SellController::searchPost($request, false);
			$buys = BuyController::searchPost($request, false);
			$fjmys = FJMYController::searchPost($request, false);
			
			$arr = [];
			foreach ($cards as $info) {
				$info->mid = 2;
				array_push($arr, $info);
			}
			foreach ($sells as $info) {
				$info->mid = 5;
				array_push($arr, $info);
			}
			foreach ($buys as $info) {
				$info->mid = 6;
				array_push($arr, $info);
			}
			foreach ($fjmys as $info) {
				$info->mid = 88;
				array_push($arr, $info);
			}
			
			return ApiResponse::makeResponse(true, $arr, ApiResponse::SUCCESS_CODE);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function Info_Banword($info, $infodata)
	{
		$info->introduce = BanWordManager::setContent($info->introduce);
		$infodata->content = BanWordManager::setContent($infodata->content);
//		$info->save();
//		$infodata->save();
		return ['info' => $info, 'infodata' => $infodata];
	}
}