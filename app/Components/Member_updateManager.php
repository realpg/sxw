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
use App\Models\Member_update;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class Member_updateManager
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
		$member_update = new Member_update();
		//这里可以对新建记录进行一定的默认设置
		$member_update->status = 2;
		$member_update->thumb = $member_update->wxqr = '';
		return $member_update;
	}
	
	
	/*
	 * 获取member_update的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$member_updates = Member_update::orderby('id', 'desc')->get();
		return $member_updates;
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
		$member_update = Member_update::where('id', '=', $id)->first();
		return $member_update;
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
		
		$member_updates = Member_update::query()->orderby($orderby['0'], $orderby['1']);
	
		foreach ($ConArr as $key => $value) {
			if (gettype($value) == 'array')
				$member_updates = $member_updates->whereIn($key, $value);
			else
				$member_updates = $member_updates->where($key, $value);
		}
		if ($paginate) {
			$member_updates = $member_updates->paginate(5);
		}
		if (!$paginate)
			$member_updates = $member_updates->get();
		return $member_updates;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setMember_update($member_update, $data, $user)
	{
		$member_update->userid = $user->userid;
		$member_update->username = $user->username;
		if (array_key_exists('truename', $data)) {
			$member_update->truename = array_get($data, 'truename');
		}
		if (array_key_exists('company', $data)) {
			$member_update->company = array_get($data, 'company');
		}
		if (array_key_exists('career', $data)) {
			$member_update->career = array_get($data, 'career');
		}
		if (array_key_exists('business', $data)) {
			$member_update->business = array_get($data, 'business');
		}
		if (array_key_exists('address', $data)) {
			$member_update->address = array_get($data, 'address');
		}
		if (array_key_exists('introduce', $data)) {
			$member_update->introduce = array_get($data, 'introduce');
		}
		if (array_key_exists('thumb', $data)) {
			$member_update->thumb = array_get($data, 'thumb');
		}
		if (array_key_exists('wxqr', $data)) {
			$member_update->wxqr = array_get($data, 'wxqr');
		}
		if (array_key_exists('ywlb_ids', $data)) {
			$member_update->ywlb_ids = array_get($data, 'ywlb_ids');
		}
		$member_update->addtime = time();
		return $member_update;
	}
	
	public static function getHistory($userid)
	{
		$member = Member::where('userid', '=', $userid)->first();
		$company = Company::where('userid', '=', $userid)->first();
		$ywlbs=CompanyYWLBManager::getByCon(['userid'=>[$userid]])->pluck('ywlb_id');
		
		$history = [
			'truename' => $member->company,
//			'mobile'=>$member->mobile,
			'company' => $member->company,
			'career' => $member->career,
			'wxqr' => $member->wxqr,
			'ywlb_ids' =>$ywlbs,
			'business' => $company->business,
			'address' => $company->address,
			'introduce' => $company->introduce,
			'thumb' => $company->thumb
		];
		return $history;
	}
	
	public static function setMember($member, $update)
	{
		$member->truename = $update->truename;
		$member->company = $update->company;
		$member->career = $update->career;
		$member->wxqr = $update->wxqr;
		return $member;
	}
	
	public static function setCompany($company, $update)
	{
		$company->company = $update->company;
		$company->business = $update->business;
		$company->address = $update->address;
		
		$company->introduce = $update->introduce;
		$companyData=CompanyDataManager::getById($company->userid);
		$companyData->content=$company->introduce;
		$companyData->save();
		
		$company->thumb = $update->thumb;
		return $company;
	}
}