<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\System;

class SystemManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$system=new System();
		//这里可以对新建记录进行一定的默认设置
		
		return $system;
	}
	
	
	/*
	 * 获取system的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$systems = System::orderby('id', 'desc')->get();
		return $systems;
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
		$system = System::where('id', '=', $id)->first();
		return $system;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-04-19
	 */
	public static function getByCon($ConArr, $orderby = ['id', 'asc'])
	{
		$systems = System::orderby($orderby['0'], $orderby['1'])->get();
		foreach ($ConArr as $key => $value) {
			$systems = $systems->whereIn($key, $value);
		}
		return $systems;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setSystem($system, $data)
	{
		if (array_key_exists('name', $data)) {
			$system->name = array_get($data, 'name');
		}
		return $system;
	}
}