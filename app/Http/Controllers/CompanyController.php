<?php

namespace App\Http\Controllers;


use App\Components\CategoryManager;
use App\Components\CompanyManager;
use App\Components\CompanyYWLBManager;
use App\Components\Member_updateManager;
use App\Components\MemberManager;
use App\Components\UpgradeManager;
use App\Components\YWLBManager;
use Illuminate\Http\Request;


class CompanyController extends Controller
{
	public static function businessCard(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, [])) {
			$conditions = [];
			if (array_key_exists('conditions', $data)) {
				$conditions = $data['conditions'];
			}
			$conditions['groupid'] = [6];
			
			$users = MemberManager::getByCon($conditions,true);
			foreach ($users as $user){
				$user->bussinesscard=BussinessCardController::getByUserid($user->userid);
			}
			$ret = $users;
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function edit(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		if ($user->groupid == 5) {
			return self::upgrade($request);
		} else if ($user->groupid == 6) {
			return self::update($request);
		} else {
			return ApiResponse::makeResponse(false, "暂不支持", ApiResponse::UNKNOW_ERROR);
		}
	}
	
	private static function upgrade(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		//检验参数
		if (UpgradeManager::getByCon(['userid' => [$user->userid], 'status' => '2'])->count() > 0) {
			return ApiResponse::makeResponse(false, "已有等待审核的信息，请耐心等待", ApiResponse::UNKNOW_ERROR);
		}
		if (checkParam($data, ['truename', 'mobile', 'company', 'career', 'ywlb_ids', 'address', 'business', 'introduce'])) {
			
			$company = CompanyManager::getById($user->userid);
			$user = MemberManager::setMember($user, $data);
			$company = CompanyManager::setCompany($company, $data, $user);
			
			$upgrade = UpgradeManager::createObject();
			$upgrade = UpgradeManager::setUpgrade($upgrade, $user);
//			$user->groupid=6;
			$upgrade->groupid = 6;
			$upgrade->groupid = 6;
			$ywlbs = explode(',', $data['ywlb_ids']);
			CompanyManager::setYWLB($company, $ywlbs, 3);
			
			$user->save();
			$company->save();
			$upgrade->save();
			
			$ret = "修改信息申请已提交，请等待审核";
//			$user->ywlb = CompanyYWLBManager::getByCon(['userid' => $user->userid]);
//			$ret = ['user' => $user, 'company' => $company, 'upgrade' => $upgrade];
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数" . array_keys($data), ApiResponse::MISSING_PARAM);
		}
	}
	
	private static function update(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		if (Member_updateManager::getByCon(['userid' => [$user->userid], 'status' => '2'])->count() > 0) {
			return ApiResponse::makeResponse(false, "已有等待审核的信息，请耐心等待", ApiResponse::UNKNOW_ERROR);
		}
		//检验参数
		if (checkParam($data, ['truename', 'mobile', 'company', 'career', 'ywlb_ids', 'address', 'business', 'introduce'])) {
			
			$update = Member_updateManager::createObject();
			$update = Member_updateManager::setMember_update($update, $data, $user);
			$update->history = json_encode(Member_updateManager::getHistory($update->userid));
			$update->save();
			
			$ret = "修改信息申请已提交，请等待审核";
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function getEditInfo(Request $request)
	{
		$data = $request->all();
		$ret = [];
		$ret['ywlb'] = YWLBManager::getByCon(['status' => '3']);
		$ret['businesscard'] = BussinessCardController::getByUserid($data['userid']);
		return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
	}
}
