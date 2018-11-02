<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\CompanyYWLB;

class CompanyYWLBManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$companyYWLB=new CompanyYWLB();
		//这里可以对新建记录进行一定的默认设置
		
		return $companyYWLB;
	}
	
	
	/*
	 * 获取companyYWLB的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$companyYWLBs = CompanyYWLB::orderby('userid', 'desc')->get();
		return $companyYWLBs;
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
		$companyYWLB = CompanyYWLB::where('userid', '=', $id)->first();
		return $companyYWLB;
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
		
		$companyYWLBs = CompanyYWLB::query()->orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$companyYWLBs = $companyYWLBs->get();
		foreach ($ConArr as $key => $value) {
			$companyYWLBs = $companyYWLBs->whereIn($key, $value);
		}
		if ($paginate) {
			$companyYWLBs = $companyYWLBs->paginate(5);
		}
		
		return $companyYWLBs;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setCompanyYWLB($companyYWLB, $data)
	{
		if (array_key_exists('name', $data)) {
			$companyYWLB->name = array_get($data, 'name');
		}
		return $companyYWLB;
	}
	
	public static function setCompanyYWLBByCompanyAndYWLB($companyYWLB, $company,$YWLB)
	{
		$companyYWLB->userid=$company->userid;
		$companyYWLB->ywlb_id=$YWLB->id;
		$companyYWLB->name=$YWLB->name;
		return $companyYWLB;
	}
	
	public static function getCompanyYWLB($userid){
		return CompanyYWLB::where('userid',$userid)->where('status', '3')
			->pluck('ywlb_id');
	}
}