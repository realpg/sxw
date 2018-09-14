<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\FJMY_data;

class FJMYDataManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$fjmyData=new FJMY_data();
		//这里可以对新建记录进行一定的默认设置
		
		return $fjmyData;
	}
	
	
	/*
	 * 获取fjmyData的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$fjmyDatas = FJMY_data::orderby('itemid', 'desc')->get();
		return $fjmyDatas;
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
		$fjmyData = FJMY_data::where('itemid', '=', $id)->first();
		return $fjmyData;
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
		$fjmyDatas = FJMY_data::orderby($orderby['0'], $orderby['1'])->get();
		foreach ($ConArr as $key => $value) {
			$fjmyDatas = $fjmyDatas->whereIn($key, $value);
		}
		return $fjmyDatas;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setFJMYData($fjmyData, $data)
	{
		if (array_key_exists('content', $data)) {
			$fjmyData->content = array_get($data, 'content');
		}
		if (array_key_exists('desc', $data)) {
			$fjmyData->content = array_get($data, 'desc');
		}
		return $fjmyData;
	}
}