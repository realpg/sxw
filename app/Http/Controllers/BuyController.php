<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/7/10
 * Time: 9:31
 */

namespace App\Http\Controllers;

use App\Components\BuyDataManager;
use App\Components\BuyManager;
use App\Components\BuySearchManager;
use App\Components\CategoryManager;
use App\Components\CompanyManager;
use App\Components\LLJLManager;
use App\Components\MemberManager;
use App\Components\SystemManager;
use App\Components\TagManager;
use Illuminate\Http\Request;

class BuyController
{
	public function getList(Request $request)
	{
		$buys = BuyManager::getByCon(['status'=>[3]],['vip','desc'],true);
//		return ApiResponse::makeResponse(true, $buys, ApiResponse::SUCCESS_CODE);
		foreach ($buys as $buy) {
			$buy = BuyManager::getInfo($buy, ['content', 'userinfo', 'tags']);
		}
		return ApiResponse::makeResponse(true, $buys, ApiResponse::SUCCESS_CODE);
	}
	
	public function edit(Request $request)
	{
		$ret = [];
		$ret['catids'] = array_arrange(CategoryManager::getByCon(['moduleid' => [6]]));
		$ret['tags'] = array_arrange(TagManager::getByCon(['moduleid' => [6]]));
		return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
	}
	
	public function editPost(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		if ($user->groupid != 6) {
			return ApiResponse::makeResponse(false, "请先完善资料", ApiResponse::UNKNOW_ERROR);
		}
		//检验参数
		if (checkParam($data, ['title', 'introduce', 'content', 'thumb', 'telephone','address'])) {
			
			if (array_key_exists('itemid', $data)) {
				$buy = BuyManager::getById($data['itemid']);
				$buy_data = BuyDataManager::getById($data['itemid']);
			} else {
				$buy = BuyManager::createObject();
				$buy_data = BuyDataManager::createObject();
				
				if (!CreditController::changeCredit(
					['userid' => $data['userid'], 'amount' => -1 * SystemManager::getById('5')->value,
						'reason' => '发布求购信息消耗积分', 'note' => '消耗积分'])) {
					return ApiResponse::makeResponse(false, "积分不足", ApiResponse::UNKNOW_ERROR);
				};
			}
			if ($buy == null) {
				return ApiResponse::makeResponse(false, "错误的itemid", ApiResponse::UNKNOW_ERROR);
			}
			
			$buy = BuyManager::setUserInfo($buy, $data['userid']);
			$buy = BuyManager::setBuy($buy, $data);
			$buy->username = $user->username;
			$buy->save();
			
			$buy_data = BuyDataManager::setBuyData($buy_data, $data);
			$buy_data->itemid = $buy->itemid;
			$buy_data->save();
			
			$searchInfo = BuyManager::createSearchInfo($buy);
			if (array_key_exists('keywords', $data)) {
				$searchInfo->content .= $data['keywords'];
			}
			$searchInfo->save();
			
			return ApiResponse::makeResponse(true, $buy, ApiResponse::SUCCESS_CODE);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function getById(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		//检验参数
		if (checkParam($data, ['itemid'])) {
			$buy = BuyManager::getById($data['itemid']);
			if ($buy) {
				//增加浏览次数
				$buy->hits++;
				$buy->save();
				$lljl = LLJLManager::createObject($user, $buy, 6);
				$lljl->save();
				$buy = BuyManager::getData($buy);
				$buy=BuyManager::getInfo($buy, ['content', 'userinfo', 'tags','comments']);
				return ApiResponse::makeResponse(true, $buy, ApiResponse::SUCCESS_CODE);
			} else
				return ApiResponse::makeResponse(false, '未找到对应信息', ApiResponse::UNKNOW_ERROR);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function searchPost(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['keyword'])) {
			$ret = null;
			$keyword = $data['keyword'];
			$searchResults = BuySearchManager::search($keyword);
			$result_itemids = [];
			if ($searchResults->count() > 0) {
				foreach ($searchResults as $result) {
					array_push($result_itemids, $result->itemid);
				}
				$buys = BuyManager::getByCon(['status' => [3], 'itemid' => $result_itemids], ['vip', 'desc'], true);
				foreach ($buys as $buy) {
					$buy->content = BuyDataManager::getById($buy->itemid)->content;
					$buy->user = $user = MemberManager::getByUsername($buy->username);
					if ($user) {
						$buy->company = $company = CompanyManager::getById($user->userid);
						$buy->businesscard = BussinessCardController::getByUserid($company->userid);
					}
					$buy->tags = TagManager::getByCon(['tagid' => explode(',', $buy->tag)]);
				}
				return ApiResponse::makeResponse(true, $searchResults, ApiResponse::SUCCESS_CODE);
			} else
				return ApiResponse::makeResponse(false, $keyword, ApiResponse::SUCCESS_CODE);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function getByCon(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['conditions'])) {
			$ret = "请求成功";
			
			$conditions1 = $data['conditions'];
			$conditions = json_decode($conditions1);
			$Con = [];
			foreach ($conditions->key as $num => $key) {
				$Con[$key] = explode(',', $conditions->value[$num]);
			}
			$buys = BuyManager::getByCon($Con,['vip','desc'],true);
			foreach ($buys as $buy) {
				$buy = BuyManager::getInfo($buy, ['content', 'userinfo', 'tags']);
			}
			return ApiResponse::makeResponse(true, $buys, ApiResponse::SUCCESS_CODE);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
}