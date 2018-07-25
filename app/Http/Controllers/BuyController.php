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
use App\Components\LLJLManager;
use App\Components\MemberManager;
use App\Components\TagManager;
use Illuminate\Http\Request;

class BuyController
{
	public function getList(Request $request)
	{
		return ApiResponse::makeResponse(true, BuyManager::getList(), ApiResponse::SUCCESS_CODE);
	}
	
	public function edit(Request $request)
	{
		$ret = [];
		$ret['catids'] = CategoryManager::getByCon(['moduleid' => [6]]);
		$ret['tags'] = TagManager::getByCon(['moduleid' => [6]]);
		return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
	}
	
	public function editPost(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['title', 'introduce', 'amount', 'price',  'content', 'thumb', 'telephone'])) {
			
			if (array_key_exists('itemid', $data)) {
				$buy = BuyManager::getById($data['itemid']);
				$buy_data = BuyDataManager::getById($data['itemid']);
			} else {
				$buy = BuyManager::createObject();
				$buy_data = BuyDataManager::createObject();
			}
			if($buy==null){
				return ApiResponse::makeResponse(false, "错误的itemid" , ApiResponse::UNKNOW_ERROR);
			}
			
			$buy = BuyManager::setUserInfo($buy, $data['userid']);
			$buy = BuyManager::setBuy($buy, $data);
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
			return ApiResponse::makeResponse(false, "缺少参数" , ApiResponse::MISSING_PARAM);
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
			if ($searchResults->count() > 0) {
				foreach ($searchResults as $result) {
					$result->item = BuyManager::getById($result->itemid);
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
			
			$buys = BuyManager::getByCon($Con);
			
			return ApiResponse::makeResponse(true, $buys, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
}