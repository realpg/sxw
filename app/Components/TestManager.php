<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Test;

class TestManager
{
	
	/*
	 * 获取Test的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$Tests = Test::orderby('id', 'desc')->get();
		return $Tests;
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
		$Test = Test::where('id', '=', $id)->first();
		return $Test;
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
		$Tests = Test::orderby($orderby['0'], $orderby['1'])->get();
		foreach ($ConArr as $key => $value) {
			$Tests = $Tests->whereIn($key, $value);
		}
		return $Tests;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setTest($Test, $data)
	{
		if (array_key_exists('name', $data)) {
			$Test->name = array_get($data, 'name');
		}
		return $Test;
	}
	
	
}