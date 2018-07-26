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
use App\Models\Buy_data;
use App\Models\Buy_search;
use App\Models\Member;

class BuyManager
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
		$buy = new Buy();
		//这里可以对新建记录进行一定的默认设置
		$buy->catid = 2;//默认值
		$buy->typeid = 0;//默认值
		$buy->n1 = $buy->n2 = $buy->n3 = '';
		$buy->v1 = $buy->v2 = $buy->v3 = '';
		$buy->thumbs = '';
		$buy->vip = 0;
		$buy->validated = 0;
		$buy->editdate = $buy->adddate = date("Y-m-d");
		$buy->addtime = time();
		$buy->template = '';
		$buysh = SystemManager::getById('2');
		if ($buysh->value == 1)
			$buy->status = 2;
		else
			$buy->status = 3;
		$buy->pack = '';
		
		return $buy;
	}
	
	public static function setUserInfo($buy, $user_id)
	{
		$member = MemberManager::getById($user_id);
		$buy->username = $member->username;
		$buy->groupid = $member->groupid;
		$buy->company = $member->company;
		$buy->truename = $member->truename;
		$buy->telephone = $member->telephone;
		$buy->mobile = $member->mobile;
		$buy->address = $member->address ? $member->address : "未知";
		$buy->email = $member->email;
		$buy->qq = $member->qq;
		$buy->wx = $member->wx;
		$buy->ali = $member->ali;
		$buy->skype = $member->skype;
		return $buy;
	}
	
	/*
	 * 获取buy的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$buys = Buy::orderby('itemid', 'desc')->paginate();
		return $buys;
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
		$buy = Buy::where('itemid', '=', $id)->first();
		return $buy;
	}
	
	public static function getData($buy)
	{
		if ($buy) {
			
			$buy->data = BuyDataManager::getById($buy->itemid);
		}
		return $buy;
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
		$buys = Buy::orderby($orderby['0'], $orderby['1']);
		foreach ($ConArr as $key => $value) {
			if ($key == 'userid') {
				$users = MemberManager::getByCon([$key => $value]);
				$usernames = [];
				foreach ($users as $user) {
					array_push($usernames, $user->username);
				}
				
				$buys = $buys->whereIn('username', $usernames);
			} else {
				$buys = $buys->whereIn($key, $value);
			}
		}
		$buys = $buys->paginate();
		return $buys;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setBuy($buy, $data)
	{
		if (array_key_exists('title', $data)) {
			$buy->title = array_get($data, 'title');
		}
		if (array_key_exists('introduce', $data)) {
			$buy->introduce = array_get($data, 'introduce');
		}
		if (array_key_exists('catid', $data)) {
			$buy->catid = array_get($data, 'catid');
		}
		if (array_key_exists('amount', $data)) {
			$buy->amount = array_get($data, 'amount');
		}
		if (array_key_exists('price', $data)) {
			$buy->price = array_get($data, 'price');
		}
		if (array_key_exists('tag', $data)) {
			$buy->tag = array_get($data, 'tag');
		}
		if (array_key_exists('thumb', $data)) {
			$buy->thumb = array_get($data, 'thumb');
		}
		if (array_key_exists('telephone', $data)) {
			$buy->telephone = array_get($data, 'telephone');
		}
		$buy->keyword = $buy->title . ',' . '求购' . '求购分类';//*****需要改动*****
		$buy->editor = MemberManager::getById($data['userid'])->username;
		$buy->editdate = date("Y-m-d");
		$buy->edittime = time();
		
		return $buy;
	}
	
	public static function createSearchInfo($buy)
	{
		$searchInfo = BuySearchManager::getByItemId($buy->itemid);
		$searchInfo->content = '求购，';
		
		$searchInfo->content .= $buy->title . ',';
		
		$searchInfo->catid = $buy->catid;
		$cat = CategoryManager::getById($buy->catid);
		$searchInfo->content .= $cat->catname . ',';
		
		return $searchInfo;
	}
}