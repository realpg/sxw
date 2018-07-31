<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\AD;

class ADManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$ad=new AD();
		//这里可以对新建记录进行一定的默认设置
		
		return $ad;
	}
	
	
	/*
	 * 获取ad的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$ads = AD::orderby('itemid', 'desc')->get();
		return $ads;
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
		$ad = AD::where('itemid', '=', $id)->first();
		return $ad;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-07-18
	 */
	public static function getByCon(array $ConArr, $paginate = false, $orderby = ['itemid', 'asc'])
	{
		
		$ads = AD::orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$ads = $ads->get();
		foreach ($ConArr as $key => $value) {
			$ads = $ads->whereIn($key, $value);
		}
		if ($paginate) {
			$ads = $ads->paginate();
		}
		return $ads;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setAD($ad, $data)
	{
		if (array_key_exists('name', $data)) {
			$ad->name = array_get($data, 'name');
		}
		return $ad;
	}
}