<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/8/6
 * Time: 17:12
 */

namespace App\Http\Controllers;

use App\Components\AgreeManager;
use App\Components\BuyManager;
use App\Components\CompanyManager;
use App\Components\CompanyYWLBManager;
use App\Components\FavoriteManager;
use App\Components\InfoManager;
use App\Components\LLJLManager;
use App\Components\MemberManager;
use App\Components\QRManager;
use App\Components\SellManager;
use App\Components\VIPUserManager;
use App\Components\YWLBManager;
use App\Models\Favorite;
use Faker\Provider\da_DK\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BussinessCardController extends Controller
{
	public static function getList(Request $request)
	{
		$data = $request->all();
		$Me = MemberManager::getById($data['userid']);
		//检验参数
		if (checkParam($data, [])) {
			$conditions = [];
			if (array_key_exists('conditions', $data)) {
				$conditions = $data['conditions'];
			}
			$conditions['groupid'] = [6];
			
			$users = MemberManager::getByCon($conditions, true);
			foreach ($users as $user) {
				$user->bussinesscard = BussinessCardController::getByUserid($user->userid, $Me);
			}
			$ret = $users;
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function getByUserid($userid, $_user = null, $getQR = false)
	{
		$member = MemberManager::getById($userid);
		if (!$member)
			return null;
		$company = CompanyManager::getById($userid);
		if (!$company)
			return null;
		$bussnesscard = [
			'userid' => $member->userid,
			'truename' => $member->truename,
			'mobile' => $member->mobile,
			'company' => $member->company,
			'career' => $member->career,
			'ywlb_ids' => implode(',', array_arrange(CompanyYWLBManager::getByCon(['userid' => [$member->userid]])->pluck('ywlb_id'))),
			'ywlb' => array_arrange(CompanyYWLBManager::getByCon(['userid' => [$member->userid]])),
			'address' => $company->address,
			'business' => $company->business,
			'introduce' => $company->introduce,
			'thumb' => $company->thumb,
			'wxqr' => $member->wxqr,
			'view' => $company->hits,
			'agree' => $company->agree,
			'favorite' => $company->favorite,
			'vip' => VIPUserManager::getUserVIPLevel($member->userid),
			'avatarUrl' => $member->avatarUrl,
			'infos' => InfoManager::CountInfosByUsername($member->username),
			'buys' => BuyManager::CountInfosByUsername($member->username),
			'sells' => SellManager::CountInfosByUsername($member->username),
		];
		if ($getQR) {
			$bussnesscard['xcxqr'] = QRManager::getCardQRByUserid($member->userid)->qr_url;
		}
		if ($_user) {
			$bussnesscard['I_agree'] = AgreeManager::getByCon(
				['item_mid' => ['2'],
					'item_id' => [$member->userid],
					'username' => [$_user->username]
				])->first() ? true : false;;
			$bussnesscard['I_favorite'] = FavoriteManager::getByCon(
				['mid' => ['2'],
					'tid' => [$member->userid],
					'userid' => [$_user->userid]
				]
			)->first() ? true : false;
		}
		return $bussnesscard;
	}
	
	public static function getYWLB()
	{
		$ywlbs = YWLBManager::getByCon(['status' => [3]]);
		return ApiResponse::makeResponse(true, array_arrange($ywlbs), ApiResponse::SUCCESS_CODE);
	}
	
	public static function getByUserid_get(Request $request)
	{
		$data = $request->all();
		$me = MemberManager::getById($data['userid']);
		//检验参数
		if (checkParam($data, ['user_id'])) {
			$company = CompanyManager::getById($data['user_id']);
			if ($company) {
				$company->hits++;
				$company->save();
			}
			$ret = self::getByUserid($data['user_id'], $me, true);
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function getByYWLB(Request $request)
	{
		$data = $request->all();
		$me = MemberManager::getById($data['userid']);
		//检验参数
		if (checkParam($data, ['ywlb_id'])) {
			$userids = CompanyYWLBManager::getByCon(['ywlb_id' => [$data['ywlb_id']]])->pluck('userid');
			
			$users = MemberManager::getByCon(['userid' => $userids], true);
			foreach ($users as $user) {
				$user->bussinesscard = BussinessCardController::getByUserid($user->userid, $me);
			}
			$ret = $users;
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function search(Request $request, $api = true)
	{
		$data = $request->all();
		$me = MemberManager::getById($data['userid']);
		//检验参数
		if (checkParam($data, ['keyword'])) {
			$keyword = $data['keyword'];
			$searchResults = CompanyManager::search($keyword);
			$userids = [];
			if ($searchResults->count() > 0) {
				foreach ($searchResults as $result) {
					$result->businesscard = BussinessCardController::getByUserid($result->userid, $me);
				}
			}
			if ($api)
				return ApiResponse::makeResponse(true, $searchResults, ApiResponse::SUCCESS_CODE);
			else
				return $searchResults;
		} else {
			if ($api)
				return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
			else
				return [];
		}
	}
	
	public static function getQRByUserid(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['_userid'])) {
			$url = QRManager::getCardQRByUserid($data['_userid'])->qr_url;
			$filepath = downloadImg($url);
			Log::info("保存" . $data['_userid'] . "二维码路径:" . $filepath);
			return response()->download($filepath);
//			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function getAvatarByUserid(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['_userid'])) {
			$url = MemberManager::getById($data['_userid'])->avatarUrl;
			$filepath = downloadImg($url);
			Log::info("保存" . $data['_userid'] . "头像路径:" . $filepath);
			return response()->download($filepath);
//			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function RefreshMyQR(Request $request)
	{
		$data = $request->all();
		
		//检验参数
		if (true) {
			$url = QRManager::refreshCardQRByUserid($data['userid'])->qr_url;
			$filepath = downloadImg($url);
			return response()->download($filepath);
//			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
}