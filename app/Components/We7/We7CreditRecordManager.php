<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components\We7;

use App\Models\We7\We7CreditRecord;

class We7CreditRecordManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$record=new We7CreditRecord();
		//这里可以对新建记录进行一定的默认设置
		$record->credittype='credit1';
		$record->operator='1';
		$record->module='system';
		$record->clerk_id='0';
		$record->store_id='0';
		$record->clerk_type='1';
		$record->createtime=time();
		$record->remark='DT同步积分。';
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
		$records = We7CreditRecord::orderby('id', 'desc')->get();
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
		$record = We7CreditRecord::where('id', '=', $id)->first();
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
		
		$records = We7CreditRecord::orderby($orderby['0'], $orderby['1']);
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
	public static function setWe7CreditRecord($record, $data)
	{
		if (array_key_exists('name', $data)) {
			$record->name = array_get($data, 'name');
		}
		return $record;
	}
	
	public static function getByTime($start,$end){
		$records=We7CreditRecord::where("createtime",'>',$start)->where("createtime",'<=',$end)->get();
		return $records;
	}
	
}