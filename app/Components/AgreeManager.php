<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Agree;

class AgreeManager
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
		$agree = new Agree();
		//这里可以对新建记录进行一定的默认设置
		
		return $agree;
	}
	
	
	/*
	 * 获取agree的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$agrees = Agree::orderby('itemid', 'desc')->get();
		return $agrees;
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
		$agree = Agree::where('itemid', '=', $id)->first();
		return $agree;
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
		$agrees = Agree::orderby($orderby['0'], $orderby['1']);
		foreach ($ConArr as $key => $value) {
			if ($key == 'start_time') {
				$agrees = $agrees->where('addtime', '>', $value);
			} else
				$agrees = $agrees->whereIn($key, $value);
		}
		return $agrees;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setAgree($agree, $data, $item)
	{
		if (array_key_exists('item_mid', $data)) {
			$agree->item_mid = array_get($data, 'item_mid');
		}
		if (array_get($data, 'item_mid') == 2)
			$agree->item_id = $item->userid;
		else
			$agree->item_id = $item->itemid;
		$agree->item_title = $item->title ? $item->title : '';
		$agree->item_username = $item->username;
		return $agree;
	}
	
	public static function setUserInfo($agree, $user)
	{
		$agree->username = $user->username;
		$agree->passport = $user->passport;
		return $agree;
	}
}