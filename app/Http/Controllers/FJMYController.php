<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/7/10
 * Time: 9:31
 */

namespace App\Http\Controllers;

use App\Components\FJMYDataManager;
use App\Components\FJMYManager;
use App\Components\FJMYSearchManager;
use App\Components\CategoryManager;
use App\Components\LLJLManager;
use App\Components\MemberManager;
use App\Components\TagManager;
use Illuminate\Http\Request;

class FJMYController
{
	public function getList(Request $request)
	{
		return ApiResponse::makeResponse(true, FJMYManager::getList(), ApiResponse::SUCCESS_CODE);
	}
	
	public function edit(Request $request)
	{
		$ret = [];
		$ret['catids'] = CategoryManager::getByCon(['moduleid' => [88]]);
		$ret['tags'] = TagManager::getByCon(['moduleid' => [6]]);
		return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
	}
	
	public function editPost(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['title', 'introduce', 'amount', 'price', 'content', 'thumb', 'telephone'])) {
			
			if (array_key_exists('itemid', $data)) {
				$fjmy = FJMYManager::getById($data['itemid']);
				$fjmy_data = FJMYDataManager::getById($data['itemid']);
			} else {
				$fjmy = FJMYManager::createObject();
				$fjmy_data = FJMYDataManager::createObject();
			}
			if($fjmy==null){
				return ApiResponse::makeResponse(false, "错误的itemid" , ApiResponse::UNKNOW_ERROR);
			}
			
			
			$fjmy = FJMYManager::setUserInfo($fjmy, $data['userid']);
			$fjmy = FJMYManager::setFJMY($fjmy, $data);
			$fjmy->save();
			
			$fjmy_data = FJMYDataManager::setFJMYData($fjmy_data, $data);
			$fjmy_data->itemid = $fjmy->itemid;
			$fjmy_data->save();
			
			$searchInfo = FJMYManager::createSearchInfo($fjmy);
			if (array_key_exists('keywords', $data)) {
				$searchInfo->content .= $data['keywords'];
			}
			$searchInfo->save();
			
			return ApiResponse::makeResponse(true, $fjmy, ApiResponse::SUCCESS_CODE);
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
			$fjmy = FJMYManager::getById($data['itemid']);
			if ($fjmy) {
				//增加浏览次数
				$fjmy->hits++;
				$fjmy->save();
				$lljl = LLJLManager::createObject($user, $fjmy, 88);
				$lljl->save();
				$fjmy = FJMYManager::getData($fjmy);
				return ApiResponse::makeResponse(true, $fjmy, ApiResponse::SUCCESS_CODE);
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
			$searchResults = FJMYSearchManager::search($keyword);
			if ($searchResults->count() > 0) {
				foreach ($searchResults as $result) {
					$result->item = FJMYManager::getById($result->itemid);
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
			
			$fjmys = FJMYManager::getByCon($Con);
			
			return ApiResponse::makeResponse(true, $fjmys, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
}