<?php

/**
 * Created by PhpStorm.
 * Member: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components\We7;

use App\Components\MemberManager;
use App\Models\We7\We7Member;

class We7MemberManager
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
		$member = new We7Member();
		//这里可以对新建记录进行一定的默认设置
		
		return $member;
	}
	
	
	/*
	 * 获取user的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$members = We7Member::orderby('uid', 'desc')->get();
		return $members;
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
		$member = We7Member::where('uid', '=', $id)->first();
		return $member;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-07-18
	 */
	public static function getByCon(array $ConArr, $paginate = false, $orderby = ['uid', 'asc'])
	{
		
		$members = We7Member::query()->orderBy($orderby['0'], $orderby['1']);
		if (!$paginate)
			$members = $members->get();
		foreach ($ConArr as $key => $value) {
			$members = $members->whereIn($key, $value);
		}
		if ($paginate) {
			$members = $members->paginate(5);
		}
		return $members;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setWe7Member($member, $data)
	{
		if (array_key_exists('name', $data)) {
			$member->name = array_get($data, 'name');
		}
		return $member;
	}
	
	public static function getByOpenid($openid)
	{
		$we7User=We7UserManager::getByOpenid($openid);
		if(!$we7User){
			return null;
		}
		$we7Member=self::getById($we7User->uid);
		return $we7Member;
	}
}