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
use App\Models\FJMY;
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
		$info = new Info();
		//这里可以对新建记录进行一定的默认设置
		$info->catid = 2;//默认值
		$info->typeid = 0;//默认值
		$info->n1 = $info->n2 = $info->n3 = '';
		$info->v1 = $info->v2 = $info->v3 = '';
		$info->thumbs = '';
		$info->vip = 0;
		$info->validated = 0;
		$info->editdate = $info->adddate = date("Y-m-d");
		$info->addtime = time();
		$info->template = '';
		$infosh = SystemManager::getById('2');
		if ($infosh->value == 1)
			$info->status = 2;
		else
			$info->status = 3;
		$info->pack = '';
		
		return $info;
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
		$infos = Info::orderby('itemid', 'desc')->paginate();
		return $infos;
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
		$info = Info::where('itemid', '=', $id)->first();
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
	public static function getByCon($mid,$ConArr, $orderby = ['itemid', 'asc'])
	{
		switch ($mid){
			case 5:
				$infos = Sell::orderby($orderby['0'], $orderby['1']);
				break;
			case 6:
				$infos = Buy::orderby($orderby['0'], $orderby['1']);
				break;
			case 88:
				$infos = FJMY::orderby($orderby['0'], $orderby['1']);
				break;
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
	
	
}