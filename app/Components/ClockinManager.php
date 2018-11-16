<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Clockin;

class ClockinManager
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
		$clockin = new Clockin();
		//这里可以对新建记录进行一定的默认设置
		$clockin->time=time();
		return $clockin;
	}
	
	
	/*
	 * 获取clockin的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$clockins = Clockin::orderby('id', 'desc')->get();
		return $clockins;
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
		$clockin = Clockin::where('id', '=', $id)->first();
		return $clockin;
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
		
		$clockins = Clockin::query()->orderBy($orderby['0'], $orderby['1']);
		
		foreach ($ConArr as $key => $value) {
			if (gettype($value) == 'array')
				$clockins = $clockins->whereIn($key, $value);
			else
				$clockins = $clockins->where($key, $value);
		}
		if ($paginate) {
			$clockins = $clockins->paginate(5);
		}
		if (!$paginate)
			$clockins = $clockins->get();
		return $clockins;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setClockin($clockin, $data)
	{
		if (array_key_exists('userid', $data)) {
			$clockin->userid = array_get($data, 'userid');
		}
		return $clockin;
	}
	
	public static function getByDate($userid,$date, $days = 1)
	{
		$date1 = date_create($date,timezone_open('Asia/Shanghai'));
		$date2 = date_create($date,timezone_open('Asia/Shanghai'));
		date_modify($date2, "+" . $days . " days");
		$time1 = date_timestamp_get($date1);
		$time2 = date_timestamp_get($date2);
		$clockins = Clockin::where('userid','=',$userid)
			->where('time', '>=', $time1)
			->where('time', '<=', $time2)->get();
		return $clockins;
	}
}