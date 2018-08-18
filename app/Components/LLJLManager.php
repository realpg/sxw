<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\LLJL;

class LLJLManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/12
	 */
	public static function createObject($user, $item, $moduleid)
	{
		$lljl = new LLJL();
		//这里可以对新建记录进行一定的默认设置
		$lljl->moduleid = $moduleid;
		$lljl->itemid = $item->itemid;
		$lljl->itemusername = $item->username;
		$lljl->userid = $user->userid;
		$lljl->username = $user->username;
		$lljl->passport = $user->passport;
		$lljl->time = time();
		return $lljl;
	}
	
	
	/*
	 * 获取lljl的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$lljls = LLJL::orderby('id', 'desc')->paginate(5);
		return $lljls;
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
		$lljl = LLJL::where('id', '=', $id)->first();
		return $lljl;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-04-19
	 */
	public static function getByCon(array $ConArr, $paginate = false, $orderby = ['id', 'asc'])
	{
		
		$lljls = LLJL::orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$lljls = $lljls->get();
		foreach ($ConArr as $key => $value) {
			if ($key == 'timefrom') {
				$lljls = $lljls->where('time', '>=', $value);
			} elseif ($key == 'timeto') {
				$lljls = $lljls->where('time', '<=', $value);
			} else{
				$lljls = $lljls->whereIn($key, $value);
			}
		}
		if ($paginate) {
			$lljls = $lljls->paginate();
		}
		return $lljls;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setLLJL($lljl, $data)
	{
		if (array_key_exists('name', $data)) {
			$lljl->name = array_get($data, 'name');
		}
		return $lljl;
	}
	
}