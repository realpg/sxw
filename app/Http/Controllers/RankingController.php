<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/7/23
 * Time: 9:56
 */

namespace App\Http\Controllers;

use App\Components\AgreeManager;
use App\Components\CompanyManager;
use App\Components\MemberManager;
use App\Components\RankingManager;
use Illuminate\Http\Request;

class RankingController extends Controller
{
	public static function createDailyRanking($type)
	{
		$oldranks = RankingManager::getByCon(['type' => [$type]]);
		foreach ($oldranks as $oldrank)
			$oldrank->delete();
		$start_time = time();
		if ($type == 1) {
			$start_time -= 86400;
		} elseif ($type == 2) {
			$start_time -= 7 * 86400;
		} elseif ($type == 3) {
			$start_time -= 30 * 86400;
		}
		$ranking_container = new SortContainer([], 'userid', ['cost_credit', 'get_agree'], 10);
		$ranking_container->push(['userid' => 1, 'cost_credit' => 93]);
		/*
		 *这里获取积分历史
		 * 统计排名
		 *
		 */
		$rankings = $ranking_container->getArray();
		//不足10名则按点赞数计算
		if (count($rankings) < 10) {
			$users_agrees = AgreeManager::getByCon(['start_time' => $start_time])->get()->groupBy('item_username');
			foreach ($users_agrees as $username => $agrees) {
				$user = MemberManager::getByCon(['username' => $username])->first();
				$ranking_container->push(['userid' => $user->userid, 'get_agree' => count($agrees)]);
			}
			$rankings = $ranking_container->getArray();
		}
		
		$arr = [];
		foreach ($rankings as $index => $ranking) {
			$data = array_merge($ranking, ['type' => $type, 'rank' => $index + 1]);
			$rank = RankingManager::createObject();
			$rank = RankingManager::setRanking($rank, $data);
			$rank->save();
			array_push($arr, $rank);
		}
		return $arr;
	}
	
	public static function getRanking(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['type'])) {
			$ranks = RankingManager::getByCon(['type' => [$data['type']]]);
			foreach ($ranks as  $rank){
				$company=CompanyManager::getById($rank->userid);
				$rank->bussinessCard=CompanyManager::getBussinessCard($company);
			}
			
			$ret = $ranks;
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
}