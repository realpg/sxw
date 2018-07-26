<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\XCXLog;

class XCXLogManager
{
	public static function log($url,$method,$ip,$param){
		$xcx_log=new XCXLog();
		$xcx_log->url=$url;
		$xcx_log->method=$method;
		$xcx_log->ip=$ip;
		$xcx_log->param=$param;
		$xcx_log->time=time();
		$xcx_log->save();
		return $xcx_log;
	}
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$XCXlog=new XCXLog();
		//这里可以对新建记录进行一定的默认设置
		
		return $XCXlog;
	}
	
	
	/*
	 * 获取XCXlog的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$XCXlogs = XCXLog::orderby('id', 'desc')->get();
		return $XCXlogs;
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
		$XCXlog = XCXLog::where('id', '=', $id)->first();
		return $XCXlog;
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
		
		$XCXlogs = XCXLog::orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$XCXlogs = $XCXlogs->get();
		foreach ($ConArr as $key => $value) {
			$XCXlogs = $XCXlogs->whereIn($key, $value);
		}
		if ($paginate) {
			$XCXlogs = $XCXlogs->paginate();
		}
		return $XCXlogs;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setXCXLog($XCXlog, $data)
	{
		if (array_key_exists('name', $data)) {
			$XCXlog->name = array_get($data, 'name');
		}
		return $XCXlog;
	}
}