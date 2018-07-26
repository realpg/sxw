<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/7/18
 * Time: 9:21
 */

namespace App\Http\Controllers;

use App\Components\CompanyManager;
use App\Components\LLJLManager;
use App\Components\Member_updateManager;
use App\Components\MemberManager;
use App\Components\SystemManager;
use App\Components\TagManager;
use App\Components\ThesauruManager;
use Illuminate\Http\Request;

class SystemController extends Controller
{
	public static function systemKeyValues_get()
	{
		$keyValues = SystemManager::getList(['id', 'asc']);
		return view('systemKeyValue', ['values' => $keyValues]);
	}
	
	public static function systemKeyValues_post(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['id', 'value'])) {
			$ret = $data;
			$keyvalue = SystemManager::getById($data['id']);
			$keyvalue = SystemManager::setSystem($keyvalue, $data);
			$keyvalue->save();
			
			return ApiResponse::makeResponse(true, $keyvalue, ApiResponse::SUCCESS_CODE);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function xcx_lljl(Request $request)
	{
		$data = $request->all();
		$con = [];
		if (array_key_exists('moduleid', $data)) if ($data['moduleid'] != 0)
			$con['moduleid'] = [$data['moduleid']];
		if (array_key_exists('timefrom', $data)) if ($data['timefrom'] != null) {
			$con['timefrom'] = strtotime($data['timefrom']) - 28800;
		}
		if (array_key_exists('timeto', $data)) if ($data['timeto'] != null) {
			$con['timeto'] = strtotime($data['timeto']) + 57600;
		}
		$lljls = LLJLManager::getByCon($con);
		return view('lljl', ['lljls' => $lljls, 'datas' => $con]);
	}
	
	public static function memberUpdate(Request $request)
	{
		$data = $request->all();
		$con = [];
		if (array_key_exists('status', $data)) if ($data['status'] != 0)
			$con['status'] = [$data['status']];
		$updates = Member_updateManager::getByCon($con);
		$histories = array();
		foreach ($updates as $index => $update) {
			$histories[$index] = json_decode($update->history);
			$update->history = '';
			$update->user = MemberManager::getById($update->userid);
		}
		return view('member_update', ['datas' => $updates, 'histories' => $histories]);
	}
	
	public static function memberUpdate_post(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['id', 'result'])) {
			$update = Member_updateManager::getById($data['id']);
			if ($data['result'] == 'true') {
				$userid = $update->userid;
				$member = MemberManager::getById($userid);
				$company = CompanyManager::getById($userid);
				Member_updateManager::setMember($member, $update)->save();
				Member_updateManager::setCompany($company, $update)->save();
				$update->status = 3;
				$update->save();
			} else {
				$update->status = 1;
				$update->save();
			}
			
			return ApiResponse::makeResponse(true, $update, ApiResponse::SUCCESS_CODE);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function tag(Request $request)
	{
		$data = $request->all();
		$con = [];
		if (array_key_exists('moduleid', $data)) if ($data['moduleid'] != 0)
			$con['moduleid'] = [$data['moduleid']];
		$tags = TagManager::getByCon($con);
		return view('tag.index', ['datas' => $tags]);
	}
	
	public static function tag_edit_get(Request $request)
	{
		$data = $request->all();
		if (array_key_exists('tagid', $data))
			$tag = TagManager::getById($data['tagid']);
		else
			$tag = TagManager::createObject();
		return view('tag.edit', ['data' => $tag]);
	}
	
	public static function tag_edit_post(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['moduleid', 'tagname', 'desc', 'listorder'])) {
			
			$ret = "请求成功";
			if (array_key_exists('tagid', $data) && $data['tagid'] != null)
				$tag = TagManager::getById($data['tagid']);
			else
				$tag = TagManager::createObject();
			
			$tag = TagManager::setTag($tag, $data);
			$tag->save();
			return ApiResponse::makeResponse(true, $tag, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function thesauru(Request $request)
	{
		$data = $request->all();
		$con = [];
		$thesaurus = ThesauruManager::getByCon($con);
		return view('thesauru.index', ['datas' => $thesaurus]);
	}
	
	public static function thesauru_edit_get(Request $request)
	{
		$data = $request->all();
		if (array_key_exists('id', $data))
			$thesauru = ThesauruManager::getById($data['id']);
		else
			$thesauru = ThesauruManager::createObject();
		return view('thesauru.edit', ['data' => $thesauru]);
	}
	
	public static function thesauru_edit_post(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['content'])) {
			
			$ret = "请求成功";
			if (array_key_exists('id', $data) && $data['id'] != null)
				$thesauru = ThesauruManager::getById($data['id']);
			else
				$thesauru = ThesauruManager::createObject();
			
			$thesauru = ThesauruManager::setThesauru($thesauru, $data);
			$thesauru->save();
			return ApiResponse::makeResponse(true, $thesauru, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function rebind()
	{
		return view('rebind.index');
	}
	
	public static function rebind_post(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, [ 'userid_1','userid_2'])) {
			$user1=MemberManager::getById($data['userid_1']);
			$user2=MemberManager::getById($data['userid_2']);
			$user1->wx_openId=$user2->wx_openId;
			$user2->wx_openId='';
			$user2->groupid=2;//
			
			$user1->save();
			$user2->save();
			
			return ApiResponse::makeResponse(true, [$user1,$user2], ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数".json_encode($data), ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function getUserByUserid(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['userid'])) {
			$ret = MemberManager::getById($data['userid']);
			
			if ($ret)
				return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			else
				return ApiResponse::makeResponse(false, "userid错误", ApiResponse::MISSING_PARAM);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
}
