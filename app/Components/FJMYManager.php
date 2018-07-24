<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\FJMY;
use App\Models\FJMY_data;
use App\Models\FJMY_search;
use App\Models\Member;

class FJMYManager
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
		$fjmy = new FJMY();
		//这里可以对新建记录进行一定的默认设置
		$fjmy->catid = 2;//默认值
		$fjmy->typeid = 0;//默认值
		$fjmy->n1 = $fjmy->n2 = $fjmy->n3 = '';
		$fjmy->v1 = $fjmy->v2 = $fjmy->v3 = '';
		$fjmy->thumbs = '';
		$fjmy->vip = 0;
		$fjmy->validated = 0;
		$fjmy->editdate = $fjmy->adddate = date("Y-m-d");
		$fjmy->addtime = time();
		$fjmy->template = '';
		$fjmy->status = 3;
		
		return $fjmy;
	}
	
	public static function setUserInfo($fjmy, $user_id)
	{
		$member = MemberManager::getById($user_id);
		$fjmy->username = $member->username;
		$fjmy->groupid = $member->groupid;
		$fjmy->company = $member->company;
		$fjmy->truename = $member->truename;
		$fjmy->telephone = $member->telephone;
		$fjmy->mobile = $member->mobile;
		$fjmy->address = $member->address ? $member->address : "未知";
		$fjmy->email = $member->email;
		$fjmy->qq = $member->qq;
		$fjmy->wx = $member->wx;
		$fjmy->ali = $member->ali;
		$fjmy->skype = $member->skype;
		return $fjmy;
	}
	
	/*
	 * 获取fjmy的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$fjmys = FJMY::orderby('itemid', 'desc')->paginate();
		return $fjmys;
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
		$fjmy = FJMY::where('itemid', '=', $id)->first();
		return $fjmy;
	}
	
	public static function getData($fjmy)
	{
		if ($fjmy) {
			
			$fjmy->data = FJMYDataManager::getById($fjmy->itemid);
		}
		return $fjmy;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-04-19
	 */
	public static function getByCon($ConArr, $orderby = ['itemid', 'asc'])
	{
		$fjmys = FJMY::orderby($orderby['0'], $orderby['1']);
		foreach ($ConArr as $key => $value) {
			if ($key == 'userid') {
				$users = MemberManager::getByCon([$key => $value]);
				$usernames = [];
				foreach ($users as $user) {
					array_push($usernames, $user->username);
				}
				
				$fjmys = $fjmys->whereIn('username', $usernames);
			} else {
				$fjmys = $fjmys->whereIn($key, $value);
			}
		}
		$fjmys=$fjmys->paginate();
		return $fjmys;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setFJMY($fjmy, $data)
	{
		if (array_key_exists('title', $data)) {
			$fjmy->title = array_get($data, 'title');
		}
		if (array_key_exists('introduce', $data)) {
			$fjmy->introduce = array_get($data, 'introduce');
		}
		if (array_key_exists('catid', $data)) {
			$fjmy->catid = array_get($data, 'catid');
		}
		if (array_key_exists('amount', $data)) {
			$fjmy->amount = array_get($data, 'amount');
		}
		if (array_key_exists('price', $data)) {
			$fjmy->price = array_get($data, 'price');
		}
		if (array_key_exists('tag', $data)) {
			$fjmy->tag = array_get($data, 'tag');
		}
		if (array_key_exists('thumb', $data)) {
			$fjmy->thumb = array_get($data, 'thumb');
		}
		if (array_key_exists('telephone', $data)) {
			$fjmy->telephone = array_get($data, 'telephone');
		}
		$fjmy->keyword = $fjmy->title . ',' . '求购' . '求购分类';//*****需要改动*****
		$fjmy->editor = MemberManager::getById($data['userid'])->username;
		$fjmy->editdate = date("Y-m-d");
		$fjmy->edittime = time();
		
		return $fjmy;
	}
	
	public static function createSearchInfo($fjmy)
	{
		$searchInfo = FJMYSearchManager::getByItemId($fjmy->itemid);
		$searchInfo->content = '求购，';
		
		$searchInfo->content .= $fjmy->title . ',';
		
		$searchInfo->catid = $fjmy->catid;
		$cat = CategoryManager::getById($fjmy->catid);
		$searchInfo->content .= $cat->catname . ',';
		
		return $searchInfo;
	}
}