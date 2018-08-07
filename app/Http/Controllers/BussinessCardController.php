<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/8/6
 * Time: 17:12
 */

namespace App\Http\Controllers;

use App\Components\AgreeManager;
use App\Components\CompanyManager;
use App\Components\LLJLManager;
use App\Components\MemberManager;
use App\Components\YWLBManager;
use Faker\Provider\da_DK\Company;

class BussinessCardController extends Controller
{
	public static function getByUserid($userid){
		$member=MemberManager::getById($userid);
		$company=CompanyManager::getById($userid);
		$bussnesscard=[
			'userid'=>$member->userid,
			'truename'=>$member->truename,
			'mobile'=> $member->mobile,
			'company'=> $member->company,
			'career'=> $member->career,
			'ywlb'=>[],//待补全
			'address'=>$company->address,
			'bussiness'=>$company->bussiness,
			'introduce'=>$company->introduce,
			'thumb'=>$company->introduce,
			'wxqr'=>$member->wxqr,
			'view' => LLJLManager::getByCon(['item_userid' => [$member->userid]])->count(),
			'agree' => AgreeManager::getByCon(['item_username' => [$member->username]])->count(),
			];
		return $bussnesscard;
	}
}