<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components\We7;

use App\Components\MemberManager;
use App\Models\We7\We7User;

class We7UserManager
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
		$user = new We7User();
		//这里可以对新建记录进行一定的默认设置
		
		return $user;
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
		$users = We7User::orderby('fanid', 'desc')->get();
		return $users;
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
		$user = We7User::where('fanid', '=', $id)->first();
		return $user;
	}
	
	public static function getByOpenid($id)
	{
		$user = We7User::where('openid', '=', $id)->first();
		return $user;
	}
	
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-07-18
	 */
	public static function getByCon(array $ConArr, $paginate = false, $orderby = ['fanid', 'asc'])
	{
		
		$users = We7User::query()->orderBy($orderby['0'], $orderby['1']);
		foreach ($ConArr as $key => $value) {
			if (gettype($value) == 'array')
				$users = $users->whereIn($key, $value);
			else
				$users = $users->where($key, $value);
		}
		if ($paginate) {
			$users = $users->paginate(5);
		}
		if (!$paginate)
			$users = $users->get();
		return $users;
	}
	
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setWe7User($user, $data)
	{
		if (array_key_exists('name', $data)) {
			$user->name = array_get($data, 'name');
		}
		return $user;
	}
	
	public static function getDTUserByWe7uid($uid)
	{
		$we7User=We7User::where('uid', '=', $uid)->first();
		if(!$we7User)
			return null;
		$openId = $we7User->openid;
		$user = null;
		if ($openId)
			$user = MemberManager::getByopenId($openId);
		return $user;
	}
}