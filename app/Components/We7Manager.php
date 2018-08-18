<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\We7;

class We7Manager
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
		$we7 = new We7();
		//这里可以对新建记录进行一定的默认设置
		
		return $we7;
	}
	
	
	/*
	 * 获取we7的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$we7s = We7::orderby('we7_uid', 'desc')->get();
		return $we7s;
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
		$we7 = We7::where('we7_uid', '=', $id)->first();
		return $we7;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-07-18
	 */
	public static function getByCon(array $ConArr, $paginate = false, $orderby = ['we7_uid', 'asc'])
	{
		$we7s = We7::orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$we7s = $we7s->get();
		foreach ($ConArr as $key => $value) {
			$we7s = $we7s->whereIn($key, $value);
		}
		if ($paginate) {
			$we7s = $we7s->paginate();
		}
		return $we7s;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setWe7($we7, $data)
	{
		if (array_key_exists('name', $data)) {
			$we7->name = array_get($data, 'name');
		}
		return $we7;
	}
	
	public static function getUserByWe7_uid($we7_uid)
	{
		$we7 = self::getById($we7_uid);
		$user = MemberManager::getById($we7->userid);
		return $user;
	}
}