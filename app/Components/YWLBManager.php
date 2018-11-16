<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\YWLB;

class YWLBManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$ywlb=new YWLB();
		//这里可以对新建记录进行一定的默认设置
		
		return $ywlb;
	}
	
	
	/*
	 * 获取ywlb的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$ywlbs = YWLB::orderby('id', 'desc')->get();
		return $ywlbs;
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
		$ywlb = YWLB::where('id', '=', $id)->first();
		return $ywlb;
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
		
		$ywlbs = YWLB::query()->orderby($orderby['0'], $orderby['1']);
		
		foreach ($ConArr as $key => $value) {
			if (gettype($value) == 'array')
				$ywlbs = $ywlbs->whereIn($key, $value);
			else
				$ywlbs = $ywlbs->where($key, $value);
		}
		if ($paginate) {
			$ywlbs = $ywlbs->paginate(5);
		}
		if (!$paginate)
			$ywlbs = $ywlbs->get();
		return $ywlbs;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setYWLB($ywlb, $data)
	{
		if (array_key_exists('name', $data)) {
			$ywlb->name = array_get($data, 'name');
		}
		if (array_key_exists('content', $data)) {
			$ywlb->content = array_get($data, 'content');
		}
		if (array_key_exists('icon_path', $data)) {
			$ywlb->icon_path = array_get($data, 'icon_path');
		}
		if (array_key_exists('status', $data)) {
			$ywlb->status = array_get($data, 'status');
		}
		else{
			$ywlb->status = 0;
		}
		return $ywlb;
	}
}