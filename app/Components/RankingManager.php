<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Ranking;

class RankingManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject()
	{
		$ranking = new Ranking();
		//这里可以对新建记录进行一定的默认设置
		$ranking->addtime = time();
		return $ranking;
	}
	
	
	/*
	 * 获取ranking的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$rankings = Ranking::orderby('id', 'desc')->get();
		return $rankings;
	}
	
	/*
	 * 根据id获取
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getById($id)
	{
		$ranking = Ranking::where('id', '=', $id)->first();
		return $ranking;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-07-18
	 */
	public static function getByCon(array $ConArr, $paginate = false, $orderby = ['id', 'asc'])
	{
		
		$rankings = Ranking::orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$rankings = $rankings->get();
		foreach ($ConArr as $key => $value) {
			$rankings = $rankings->whereIn($key, $value);
		}
		if ($paginate) {
			$rankings = $rankings->paginate();
		}
		return $rankings;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setRanking($ranking, $data)
	{
		if (array_key_exists('type', $data)) {
			$ranking->type = array_get($data, 'type');
		}
		if (array_key_exists('rank', $data)) {
			$ranking->rank = array_get($data, 'rank');
		}
		if (array_key_exists('userid', $data)) {
			$ranking->userid = array_get($data, 'userid');
			$ranking->username=MemberManager::getById($ranking->userid)->username;
		}
		if (array_key_exists('cost_credit', $data)) {
			$ranking->cost_credit = array_get($data, 'cost_credit');
		}
		if (array_key_exists('get_agree', $data)) {
			$ranking->get_agree = array_get($data, 'get_agree');
		}
		return $ranking;
	}
}