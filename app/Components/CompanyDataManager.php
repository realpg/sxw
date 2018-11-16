<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\CompanyData;

class CompanyDataManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$companyData=new CompanyData();
		//这里可以对新建记录进行一定的默认设置
		
		return $companyData;
	}
	
	
	/*
	 * 获取companyData的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$companyDatas = CompanyData::orderby('userid', 'desc')->get();
		return $companyDatas;
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
		$companyData = CompanyData::where('userid', '=', $id)->first();
		if(!$companyData){
			$companyData=new CompanyData();
			$companyData->userid=$id;
		}
		return $companyData;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-04-19
	 */
	public static function getByCon($ConArr, $orderby = ['userid', 'asc'])
	{
		$companyDatas = CompanyData::query()->orderBy($orderby['0'], $orderby['1']);
		foreach ($ConArr as $key => $value) {
			if (gettype($value) == 'array')
				$companyDatas = $companyDatas->whereIn($key, $value);
			else
				$companyDatas = $companyDatas->where($key, $value);
		}
		return $companyDatas->get();
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setCompanyData($companyData, $data)
	{
		if (array_key_exists('content', $data)) {
			$companyData->content = array_get($data, 'content');
		}
		return $companyData;
	}
}