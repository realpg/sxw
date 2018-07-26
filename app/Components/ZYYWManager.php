<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\ZYYW;

class ZYYWManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$zyyw=new ZYYW();
		//这里可以对新建记录进行一定的默认设置
		
		return $zyyw;
	}
	
	
	/*
	 * 获取zyyw的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$zyyws = ZYYW::orderby('id', 'desc')->get();
		return $zyyws;
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
		$zyyw = ZYYW::where('id', '=', $id)->first();
		return $zyyw;
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
		
		$zyyws = ZYYW::orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$zyyws = $zyyws->get();
		foreach ($ConArr as $key => $value) {
			$zyyws = $zyyws->whereIn($key, $value);
		}
		if ($paginate) {
			$zyyws = $zyyws->paginate();
		}
		return $zyyws;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setZYYW($zyyw, $data)
	{
		if (array_key_exists('content', $data)) {
			$zyyw->content = array_get($data, 'content');
		}
		if (array_key_exists('status', $data)) {
			$zyyw->status = array_get($data, 'status');
		}
		else{
			$zyyw->status = 0;
		}
		return $zyyw;
	}
}