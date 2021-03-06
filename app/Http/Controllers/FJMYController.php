<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/7/10
 * Time: 9:31
 */

namespace App\Http\Controllers;

use App\Components\AgreeManager;
use App\Components\CompanyManager;
use App\Components\FavoriteManager;
use App\Components\FJMYDataManager;
use App\Components\FJMYManager;
use App\Components\FJMYSearchManager;
use App\Components\CategoryManager;
use App\Components\InfoManager;
use App\Components\LLJLManager;
use App\Components\MemberManager;
use App\Components\SystemManager;
use App\Components\TagManager;
use App\Components\VIPUserManager;
use Illuminate\Http\Request;

class FJMYController
{
	public function getList(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		$fjmys = FJMYManager::getByCon(['status' => [3]], ['listorder', "asc", 'vip', 'desc'], true);
//		return ApiResponse::makeResponse(true, $fjmys, ApiResponse::SUCCESS_CODE);
		foreach ($fjmys as $fjmy) {
			$fjmy = FJMYManager::getInfo($fjmy, ['content', 'userinfo', 'tags']);
			$fjmy = FJMYManager::getAgreeAndFavorite($fjmy, $user);
		}
		return ApiResponse::makeResponse(true, $fjmys, ApiResponse::SUCCESS_CODE);
	}
	
	public function edit(Request $request)
	{
		$data = $request->all();
		$ret = [];
		$ret['catids'] = array_arrange(CategoryManager::getByCon(['moduleid' => [88]]));
		$ret['tags'] = array_arrange(TagManager::getByCon(['moduleid' => [88]]));
		if (checkParam($data, ['itemid'])) {
			$item = FJMYManager::getById($data['itemid']);
			$ret['item'] = FJMYManager::getInfo($item, ['content', 'tags']);
		}
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
		if (checkParam($data, ['title', 'introduce', 'content', 'thumb', 'telephone', 'address'])) {
			
			if (array_key_exists('itemid', $data)) {
				$fjmy = FJMYManager::getById($data['itemid']);
				$fjmy_data = FJMYDataManager::getById($data['itemid']);
				
				if (VIPUserManager::getUserVIPLevel($user->userid) != 0) {
					//VIP不消耗积分
				}
				elseif (!CreditController::changeCredit(
					['userid' => $data['userid'], 'amount' => -1 * SystemManager::getById('16')->value,
						'reason' => '修改纺机贸易信息消耗积分', 'note' => '消耗积分'])) {
					return ApiResponse::makeResponse(false, "积分不足", ApiResponse::UNKNOW_ERROR);
				};
			} else {
				$fjmy = FJMYManager::createObject();
				$fjmy_data = FJMYDataManager::createObject();
				
				$free_1 = SystemManager::getById(8)->value;
				$free_2 = SystemManager::getById(9)->value;
				//vip可以发布信息
				if (VIPUserManager::getUserVIPLevel($user->userid) != 0) {
					//VIP不消耗积分
				} elseif (InfoManager::CountInfosByUsername($user->username) < $free_1) {
					//每位用户前n次发布不消耗积分
				}
				elseif (InfoManager::CountInfosByUsername($user->username, true) < $free_2) {
					//每日前n次发布不消耗积分
				} //消耗积分
				elseif (!CreditController::changeCredit(
					['userid' => $data['userid'], 'amount' => -1 * SystemManager::getById('5')->value,
						'reason' => '发布纺机贸易信息消耗积分', 'note' => '消耗积分'])) {
					return ApiResponse::makeResponse(false, "积分不足", ApiResponse::UNKNOW_ERROR);
				};
			}
			if ($fjmy == null) {
				return ApiResponse::makeResponse(false, "错误的itemid", ApiResponse::UNKNOW_ERROR);
			}
			
			$fjmy = FJMYManager::setUserInfo($fjmy, $data['userid']);
			$fjmy = FJMYManager::setFJMY($fjmy, $data);
			$fjmy->username = $user->username;
			$fjmy->save();
			
			$fjmy_data = FJMYDataManager::setFJMYData($fjmy_data, $data);
			$fjmy_data->itemid = $fjmy->itemid;
			$fjmy_data->save();
			
			$searchInfo = FJMYManager::createSearchInfo($fjmy);
			if (array_key_exists('keywords', $data)) {
				$searchInfo->content .= $data['keywords'];
			}
			$searchInfo->save();
			
			$fjmysh = SystemManager::getById('3');
			if ($fjmysh->value == 0)//自动过审
				MessageController::sendSystemMessage([
					'title' => "您发布的[纺机]信息(ID:".$fjmy->itemid.")已经通过审核",
					'content' => "尊敬的会员：<br/>您发布的[纺机]<a href=\"http://dt.chinayarn.com/buy/\" target=\"_blank\">纺机贸易</a>(ID:".$fjmy->itemid.")已经通过审核！<br/>如果您对此操作有异议，请及时与网站联系。",
					'touser' => $user->username
				]);
			
			return ApiResponse::makeResponse(true, $fjmy, ApiResponse::SUCCESS_CODE);
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
			$fjmy = FJMYManager::getById($data['itemid']);
			if ($fjmy) {
				//增加浏览次数
				$fjmy->hits++;
				$fjmy->save();
				$lljl = LLJLManager::createObject($user, $fjmy, 88);
				$lljl->save();
				$fjmy = FJMYManager::getData($fjmy);
				$fjmy = FJMYManager::getInfo($fjmy, ['content', 'userinfo', 'tags', 'comments']);
				$fjmy = FJMYManager::getAgreeAndFavorite($fjmy, $user);
				return ApiResponse::makeResponse(true, $fjmy, ApiResponse::SUCCESS_CODE);
			} else
				return ApiResponse::makeResponse(false, '未找到对应信息', ApiResponse::UNKNOW_ERROR);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function searchPost(Request $request, $api = true)
	{
		$data = $request->all();
		$I = MemberManager::getById($data['userid']);
		//检验参数
		if (checkParam($data, ['keyword'])) {
			$ret = null;
			$keyword = $data['keyword'];
			$searchResults = FJMYSearchManager::search($keyword);
			$result_itemids = [];
			if ($searchResults->count() > 0) {
				foreach ($searchResults as $result) {
					array_push($result_itemids, $result->itemid);
				}
				$fjmys = FJMYManager::getByCon(['status' => [3], 'itemid' => $result_itemids], ['listorder', 'asc'], true);
				foreach ($fjmys as $fjmy) {
					$fjmy->content = FJMYDataManager::getById($fjmy->itemid)->content;
					$fjmy->user = $user = MemberManager::getByUsername($fjmy->username);
					if ($user) {
						$fjmy->company = $company = CompanyManager::getById($user->userid);
						$fjmy->businesscard = BussinessCardController::getByUserid($company->userid,$I);
					}
					$fjmy->tags = array_arrange(TagManager::getByCon(['tagid' => explode(',', $fjmy->tag)]));
					$fjmy = FJMYManager::getAgreeAndFavorite($fjmy, $I);
				}
				if ($api)
					return ApiResponse::makeResponse(true, $fjmys, ApiResponse::SUCCESS_CODE);
				else
					return $fjmys;
			} else
				if ($api)
					return ApiResponse::makeResponse(true, [], ApiResponse::SUCCESS_CODE);
				else
					return [];
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function getByCon(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		//检验参数
		if (checkParam($data, ['conditions'])) {
			$ret = "请求成功";
			
			$conditions1 = $data['conditions'];
			$conditions = json_decode($conditions1);
			$Con = [];
			foreach ($conditions->key as $num => $key) {
				$Con[$key] = explode(',', $conditions->value[$num]);
			}
			$fjmys = FJMYManager::getByCon($Con, ['listorder', 'asc'], true);
			foreach ($fjmys as $fjmy) {
				$fjmy = FJMYManager::getInfo($fjmy, ['content', 'userinfo', 'tags']);
				$fjmy = FJMYManager::getAgreeAndFavorite($fjmy, $user);
			}
			return ApiResponse::makeResponse(true, $fjmys, ApiResponse::SUCCESS_CODE);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
}