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
use App\Components\FinanceCreditManager;
use App\Components\MemberManager;
use App\Components\RankingManager;
use App\Models\Ranking;
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
//		$ranking_container->push(['userid' => 1, 'cost_credit' => 93]);
		/*
		 *这里获取积分历史
		 * 统计排名
		 *
		 */
		$credits = FinanceCreditManager::getByCon(['start_time' => $start_time, 'ranking' => 1])->groupBy('username');
		foreach ($credits as $username => $cost_credits) {
			$user = MemberManager::getByCon(['username' => $username])->first();
			if (!$user) {
				continue;
			} else if ($user->groupid != 6) {
				continue;
			}
			$points = 0;
			foreach ($cost_credits as $cost_credit) {
				$points += -$cost_credit->amount;
			}
			$ranking_container->push(['userid' => $user->userid, 'cost_credit' => $points]);
		}
		$rankings = $ranking_container->getArray();
		
		//不足10名则按点赞数计算
		if (count($rankings) < 10) {
			$users_agrees = AgreeManager::getByCon(['start_time' => $start_time])->get()->groupBy('item_username');
			foreach ($users_agrees as $username => $agrees) {
				$user = MemberManager::getByCon(['username' => $username])->first();
				if($user)
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
			$ranks = RankingManager::getByCon(['type' => [$data['type']]], ['rank', 'asc']);
			foreach ($ranks as $rank) {
				$company = CompanyManager::getById($rank->userid);
				$rank->businesscard = BussinessCardController::getByUserid($company->userid);
			}
			
			$ret = array_arrange($ranks);
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function clear($time = 2592000)
	{
		//默认清理一个月以前的排行榜记录
		$now = time();
		$rankings = Ranking::withTrashed()->where('addtime', '<', $now - $time);
		foreach ($rankings as $ranking) {
			$ranking->forceDelete();
		}
	}
}