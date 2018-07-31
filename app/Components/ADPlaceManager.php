<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\ADPlace;

class ADPlaceManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$ad_place=new ADPlace();
		//这里可以对新建记录进行一定的默认设置
		
		return $ad_place;
	}
	
	
	/*
	 * 获取ad_place的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$ad_places = ADPlace::orderby('pid', 'desc')->get();
		return $ad_places;
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
		$ad_place = ADPlace::where('pid', '=', $id)->first();
		return $ad_place;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-07-18
	 */
	public static function getByCon(array $ConArr, $paginate = false, $orderby = ['pid', 'asc'])
	{
		
		$ad_places = ADPlace::orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$ad_places = $ad_places->get();
		foreach ($ConArr as $key => $value) {
			$ad_places = $ad_places->whereIn($key, $value);
		}
		if ($paginate) {
			$ad_places = $ad_places->paginate();
		}
		return $ad_places;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setADPlace($ad_place, $data)
	{
		if (array_key_exists('name', $data)) {
			$ad_place->name = array_get($data, 'name');
		}
		return $ad_place;
	}
}