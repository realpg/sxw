<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Company;

class CompanyManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$company=new Company();
		//这里可以对新建记录进行一定的默认设置
		
		return $company;
	}
	
	
	/*
	 * 获取company的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$companys = Company::orderby('userid', 'desc')->get();
		return $companys;
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
		$company = Company::where('userid', '=', $id)->first();
		if ($company==null){
			$company=self::createObject();
			$company->userid = $id;
		}
		return $company;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-07-18
	 */
	public static function getByCon(array $ConArr, $paginate = false, $orderby = ['userid', 'asc'])
	{
		
		$companys = Company::orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$companys = $companys->get();
		foreach ($ConArr as $key => $value) {
			$companys = $companys->whereIn($key, $value);
		}
		if ($paginate) {
			$companys = $companys->paginate();
		}
		return $companys;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setCompany($company, $data,$user)
	{
//		if (array_key_exists('company', $data)) {
//			$company->company = array_get($data, 'company');
//		}
		if (array_key_exists('business', $data)) {
			$company->business = array_get($data, 'business');
		}
		if (array_key_exists('address', $data)) {
			$company->address = array_get($data, 'address');
		}
		if (array_key_exists('sell', $data)) {
			$company->sell = array_get($data, 'sell');
		}
		if (array_key_exists('introduce', $data)) {
			$company->introduce = array_get($data, 'introduce');
		}
		
		if (array_key_exists('thumb', $data)) {
			$company->thumb = array_get($data, 'thumb');
		}
		
		$company->userid=$user->userid;
		$company->username=$user->username;
		$company->groupid=5;
		$company->company=$user->company;
		return $company;
	}
}