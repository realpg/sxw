<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\We7\FinanceCredit;

class We7CreditManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$record=new FinanceCredit();
		//这里可以对新建记录进行一定的默认设置
		
		return $record;
	}
	
	
	/*
	 * 获取record的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$records = FinanceCredit::orderby('id', 'desc')->get();
		return $records;
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
		$record = FinanceCredit::where('id', '=', $id)->first();
		return $record;
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
		
		$records = FinanceCredit::orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$records = $records->get();
		foreach ($ConArr as $key => $value) {
			$records = $records->whereIn($key, $value);
		}
		if ($paginate) {
			$records = $records->paginate(5);
		}
		return $records;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setFinanceCredit($record, $data)
	{
		if (array_key_exists('name', $data)) {
			$record->name = array_get($data, 'name');
		}
		return $record;
	}
}