<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\VIPUser;

class VIPUserManager
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
		$vipUser = new VIPUser();
		//这里可以对新建记录进行一定的默认设置
		$vipUser->addtime = time();
		return $vipUser;
	}
	
	
	/*
	 * 获取vipUser的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$vipUsers = VIPUser::orderby('id', 'desc')->get();
		return $vipUsers;
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
		$vipUser = VIPUser::where('id', '=', $id)->first();
		return $vipUser;
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
		
		$vipUsers = VIPUser::orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$vipUsers = $vipUsers->get();
		foreach ($ConArr as $key => $value) {
			$vipUsers = $vipUsers->whereIn($key, $value);
		}
		if ($paginate) {
			$vipUsers = $vipUsers->paginate(5);
		}
		return $vipUsers;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setVIPUser($vipUser, $data)
	{
		if (array_key_exists('name', $data)) {
			$vipUser->name = array_get($data, 'name');
		}
		return $vipUser;
	}
	
	public static function setVIPUserByUserAndVIP($vipUser, $user, $vip)
	{
		$vipUser->userid = $user->userid;
		$vipUser->vip = $vip->vip;
		$vipUser->totime = $vipUser->fromtime + $vip->druation;
		$vipUser->status = $vipUser->fromtime <= time() ? 3 : 0;
		return $vipUser;
	}
	
	public static function getUserVIPLevel($userid, $time = null)
	{
		if (!$time) {
			$time = time();
		}
		$vipuser = VIPUser::where('userid', '=', $userid)->where('status', '=', '3')->first();
		return $vipuser ? $vipuser->vip : 0;
	}
}