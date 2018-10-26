<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Buy;
//use App\Models\FJMY;
use App\Models\Info;
use App\Models\Info_data;
use App\Models\Info_search;
use App\Models\Member;
use App\Models\Sell;

class InfoManager
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
	}
	
	public static function setUserInfo($info, $user_id)
	{
		$member = MemberManager::getById($user_id);
		$info->username = $member->username;
		$info->groupid = $member->groupid;
		$info->company = $member->company;
		$info->truename = $member->truename;
		$info->telephone = $member->telephone;
		$info->mobile = $member->mobile;
		$info->address = $member->address ? $member->address : "未知";
		$info->email = $member->email;
		$info->qq = $member->qq;
		$info->wx = $member->wx;
		$info->ali = $member->ali;
		$info->skype = $member->skype;
		return $info;
	}
	
	/*
	 * 获取info的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
	}
	
	/*
	 * 根据id获取
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getById($mid, $id)
	{
		$info = null;
		switch ($mid . '') {
			case '5':
				$info = SellManager::getById($id);
				break;
			case '6':
				$info = BuyManager::getById($id);
				break;
//			case '88':
//				$info = FJMYManager::getById($id);
//				break;
		}
		return $info;
	}
	
	public static function getData($info)
	{
		if ($info) {
			$info->data = InfoDataManager::getById($info->itemid);
		}
		return $info;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-04-19
	 */
	public static function getByCon($mid, $ConArr, $orderby = ['listorder', 'asc'])
	{
		switch ($mid) {
			case 5:
				$infos = Sell::orderby($orderby['0'], $orderby['1']);
				break;
			case 6:
				$infos = Buy::orderby($orderby['0'], $orderby['1']);
				break;
//			case 88:
//				$infos = FJMY::orderby($orderby['0'], $orderby['1']);
//				break;
		};
		
		
		foreach ($ConArr as $key => $value) {
			if ($key == 'userid') {
				$users = MemberManager::getByCon([$key => $value]);
				$usernames = [];
				foreach ($users as $user) {
					array_push($usernames, $user->username);
				}
				
				$infos = $infos->whereIn('username', $usernames);
			} else {
				$infos = $infos->whereIn($key, $value);
			}
		}
//		$infos = $infos->paginate();
		return $infos;
	}
	
	public static function getByPage($page = 1, $perpage = 15)
	{
		$Infos = [];
		$sells = Sell::where('status', '=', '3')->orderby('listorder', 'asc')->pluck('addtime', 'itemid');
		foreach ($sells as $itemid => $addtime) {
			array_push($Infos, ['addtime' => $addtime, 'mid' => 5, 'itemid' => $itemid]);
		}
		
		$buys = Buy::where('status', '=', '3')->orderby('listorder', 'asc')->pluck('addtime', 'itemid');
		foreach ($buys as $itemid => $addtime) {
			array_push($Infos, ['addtime' => $addtime, 'mid' => 6, 'itemid' => $itemid]);
		}
		
//		$fjmys = FJMY::where('status', '=', '3')->orderby('listorder', 'asc')->pluck('addtime', 'itemid');
//		foreach ($fjmys as $itemid => $addtime) {
//			array_push($Infos, ['addtime' => $addtime, 'mid' => 88, 'itemid' => $itemid]);
//		}
		usort($Infos, function ($a, $b) {
			if ($a['addtime'] == $b['addtime']) return 0;
			return ($a['addtime'] > $b['addtime']) ? -1 : 1;
		});
		$infos = array_slice($Infos, ($page - 1) * $perpage, $perpage);
		$items = [];
		foreach ($infos as $info) {
			$item = self::getByCon($info['mid'], ['itemid' => [$info['itemid']]])->first();
			switch ($info['mid']) {
				case '5':
					$item = SellManager::getInfo($item, ['content', 'userinfo', 'tags']);
					$item->mid = 5;
					break;
				case '6':
					$item = BuyManager::getInfo($item, ['content', 'userinfo', 'tags']);
					$item->mid = 6;
					break;
//				case '88':
//					$item = FJMYManager::getInfo($item, ['content', 'userinfo', 'tags']);
//					$item->mid = 88;
//					break;
			}
			array_push($items, $item);
		}
		
		$ret = [
			'current_page' => $page,
			'data' => $items,
			"from" => ($page - 1) * $perpage + 1,
			'last_page' => (int)(count($Infos) / $perpage) + 1,
			'next_page' => $page < ((int)(count($Infos) / $perpage) + 1) ? $page + 1 : null,
			'per_page' => $perpage,
			'to' => ($page - 1) * $perpage + 1 + count($items),
			'total' => count($Infos)
		];
		return $ret;
	}
	
	public static function getByUsernameAndPage($username, $page = 1, $perpage = 15)
	{
		$Infos = [];
		$sells = Sell::where('status', '=', '3')->where('username', '=', $username)->orderby('listorder', 'asc')->pluck('addtime', 'itemid');
		foreach ($sells as $itemid => $addtime) {
			array_push($Infos, ['addtime' => $addtime, 'mid' => 5, 'itemid' => $itemid]);
		}
		
		$buys = Buy::where('status', '=', '3')->where('username', '=', $username)->orderby('listorder', 'asc')->pluck('addtime', 'itemid');
		foreach ($buys as $itemid => $addtime) {
			array_push($Infos, ['addtime' => $addtime, 'mid' => 6, 'itemid' => $itemid]);
		}
		
//		$fjmys = FJMY::where('status', '=', '3')->where('username', '=', $username)->orderby('listorder', 'asc')->pluck('addtime', 'itemid');
//		foreach ($fjmys as $itemid => $addtime) {
//			array_push($Infos, ['addtime' => $addtime, 'mid' => 88, 'itemid' => $itemid]);
//		}
		usort($Infos, function ($a, $b) {
			if ($a['addtime'] == $b['addtime']) return 0;
			return ($a['addtime'] > $b['addtime']) ? -1 : 1;
		});
		$infos = array_slice($Infos, ($page - 1) * $perpage, $perpage);
		$items = [];
		foreach ($infos as $info) {
			$item = self::getByCon($info['mid'], ['itemid' => [$info['itemid']]])->first();
			switch ($info['mid']) {
				case '5':
					$item = SellManager::getInfo($item, ['content', 'userinfo', 'tags']);
					$item->mid = 5;
					break;
				case '6':
					$item = BuyManager::getInfo($item, ['content', 'userinfo', 'tags']);
					$item->mid = 6;
					break;
//				case '88':
//					$item = FJMYManager::getInfo($item, ['content', 'userinfo', 'tags']);
//					$item->mid = 88;
//					break;
			}
			array_push($items, $item);
		}
		
		$ret = [
			'current_page' => $page,
			'data' => $items,
			"from" => ($page - 1) * $perpage + count($items) > 0 ? 1 : 0,
			'last_page' => (int)(count($Infos) / $perpage) + 1,
			'next_page' => $page < ((int)(count($Infos) / $perpage) + 1) ? $page + 1 : null,
			'per_page' => $perpage,
			'to' => ($page - 1) * $perpage + count($items),
			'total' => count($Infos)
		];
		return $ret;
	}
	
	public static function CountInfosByUsername($username, $today = false)
	{
		if ($today) {
			$time0=$today = strtotime(date("Y-m-d"),time());
			$sells = Sell::where('username', $username)->where("addtime",">=",$time0)->count();
			$buys = Buy::where('username', $username)->where("addtime",">=",$time0)->count();
//			$fjmys = FJMY::where('username', $username)->where("addtime",">=",$time0)->count();
		} else {
			$sells = Sell::where('username', $username)->count();
			$buys = Buy::where('username', $username)->count();
//			$fjmys = FJMY::where('username', $username)->count();
		}
		return $sells + $buys
//			+ $fjmys
			;
	}
}