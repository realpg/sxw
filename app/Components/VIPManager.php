<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\VIP;

class VIPManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$vip=new VIP();
		//这里可以对新建记录进行一定的默认设置
		
		return $vip;
	}
	
	
	/*
	 * 获取vip的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$vips = VIP::orderby('id', 'desc')->get();
		return $vips;
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
		$vip = VIP::where('id', '=', $id)->first();
		return $vip;
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
		
		$vips = VIP::orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$vips = $vips->get();
		foreach ($ConArr as $key => $value) {
			$vips = $vips->whereIn($key, $value);
		}
		if ($paginate) {
			$vips = $vips->paginate(5);
		}
		return $vips;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setVIP($vip, $data)
	{
		if (array_key_exists('vip', $data)) {
			$vip->vip = array_get($data, 'vip');
		}
		if (array_key_exists('druation', $data)) {
			$vip->druation = array_get($data, 'druation')*86400;
		}
		if (array_key_exists('desc', $data)) {
			$vip->desc = array_get($data, 'desc');
		}
		if (array_key_exists('amount', $data)) {
			$vip->amount = array_get($data, 'amount');
		}
		return $vip;
	}
}