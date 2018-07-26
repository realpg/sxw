<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/7/10
 * Time: 9:31
 */

namespace App\Http\Controllers;

use App\Components\ArticleDataManager;
use App\Components\ArticleManager;
//use App\Components\ArticleSearchManager;
use App\Components\CategoryManager;
use App\Components\LLJLManager;
use App\Components\MemberManager;
use App\Components\TagManager;
use Illuminate\Http\Request;

class ArticleController
{
	public function getList(Request $request)
	{
		return ApiResponse::makeResponse(true, ArticleManager::getList(), ApiResponse::SUCCESS_CODE);
	}
	
	
	
	public static function getById(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		//检验参数
		if (checkParam($data, ['itemid'])) {
			$buy = ArticleManager::getById($data['itemid']);
			if ($buy) {
				//增加浏览次数
				$buy->hits++;
				$buy->save();
				$lljl = LLJLManager::createObject($user, $buy, 6);
				$lljl->save();
				$buy = ArticleManager::getData($buy);
				return ApiResponse::makeResponse(true, $buy, ApiResponse::SUCCESS_CODE);
			} else
				return ApiResponse::makeResponse(false, '未找到对应信息', ApiResponse::UNKNOW_ERROR);
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
			
			$buys = ArticleManager::getByCon($Con);
			
			return ApiResponse::makeResponse(true, $buys, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
}