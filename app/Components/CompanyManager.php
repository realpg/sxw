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
use App\Models\CompanyData;
use App\Models\CompanyYWLB;
use App\Models\Favorite;

class CompanyManager
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
		$company = new Company();
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
	public static function getList($paginate = false)
	{
		if ($paginate)
			$companys = Company::orderby('userid', 'desc')->paginate(5);
		else
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
		if ($company == null) {
			$company = self::createObject();
			$company->userid = $id;
		}
		return $company;
	}
	
	public static function getByUsername($username)
	{
		$company = Company::where('username', '=', $username)->first();
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
			$companys = $companys->paginate(5);
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
	public static function setCompany($company, $data, $user)
	{
		if (array_key_exists('company', $data)) {
			$company->company = array_get($data, 'company');
		}
		if (array_key_exists('business', $data)) {
			$company->business = array_get($data, 'business');
		}
		if (array_key_exists('address', $data)) {
			$company->address = array_get($data, 'address');
		}
		if (array_key_exists('introduce', $data)) {
			$company->introduce = array_get($data, 'introduce');
			$companyData = CompanyDataManager::getById($company->userid);
			$companyData->content = $company->introduce;
			$companyData->save();
		}
		
		if (array_key_exists('thumb', $data)) {
			if (gettype(array_get($data,'thumb')) == 'string')
				$company->thumb = array_get($data, 'thumb');
			elseif (gettype(array_get($data,'thumb')) == 'array')
				$company->thumb = implode(',', array_get($data, 'thumb'));
		}
		
		$company->userid = $user->userid;
		$company->username = $user->username;
		$company->groupid = 5;
		$company->company = $user->company;
		return $company;
	}
	
	public static function setYWLB($company, $ywlbs, $status = 2)
	{
		if ($status = 3) {
			$companyYWLBs = CompanyYWLBManager::getByCon(['userid' => [$company->userid]]);
			foreach ($companyYWLBs as $companyYWLB) {
				$companyYWLB->delete();
			}
		}
		
		foreach ($ywlbs as $ywlb) {
			$YWLB = YWLBManager::getById($ywlb);
			$companyYWLB = CompanyYWLBManager::createObject();
			$companyYWLB->userid = $company->userid;
			$companyYWLB->ywlb_id = $YWLB->id;
			$companyYWLB->name = $YWLB->name;
			$companyYWLB->status = $status;
			$companyYWLB->save();
			$company->keyword.= $YWLB->name . ',';
		}
		
	}
	
	public static function setKeyWords($company, $ywlbs, $user)
	{
		$company->keyword = $user->truename;
		foreach ($ywlbs as $ywlb) {
			$YWLB = YWLBManager::getById($ywlb);
			$company->keyword .= ',' . $YWLB->name;
		}
		$company->keyword = trim($company->keyword, ',');
		return $company;
	}
	
	public static function getBussinessCard($company)
	{
		$member = MemberManager::getById($company->userid);
		
		if ($member)
			$businessCard = [
				'userid' => $member->userid,
				'truename' => $member->truename,
				'career' => $member->career,
				'company' => $member->company,
				'address' => $company->address,
				'sell' => $company->sell,
				'introduce' => $company->introduce,
				'business' => $company->business,
				'telephone' => $member->telephone,
				'view' => LLJLManager::getByCon(['item_userid' => [$member->userid]])->count(),
				'agree' => AgreeManager::getByCon(['item_username' => [$member->username]])->count(),
//				'favorite'=>Favorite::
			];
		else
			$businessCard = null;
		return $businessCard;
	}
	
	public static function search($keyword)
	{
		$results = Company::where('company', 'like', '%' . $keyword . "%")
			->orWhere('business', 'like', '%' . $keyword . "%")
			->orWhere('introduce', 'like', '%' . $keyword . "%")
			->orWhere('keyword', 'like', '%' . $keyword . "%")
			->orWhere('address', 'like', '%' . $keyword . "%");
		
		$thesauru = ThesauruManager::getByKeyword($keyword);
		if ($thesauru) {
			$words = explode('=', $thesauru->content);
			foreach ($words as $word) {
				$results = $results->orWhere('company', 'like', '%' . $word . "%")
					->orWhere('business', 'like', '%' . $word . "%")
					->orWhere('introduce', 'like', '%' . $word . "%")
					->orWhere('keyword', 'like', '%' . $word . "%")
					->orWhere('address', 'like', '%' . $word . "%");
			}
		}
		$results = $results->paginate(5);
		return $results;
	}
}