<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Http\Controllers\BussinessCardController;
use App\Models\FJMY;
use App\Models\FJMY_data;
use App\Models\FJMY_search;
use App\Models\Member;

class FJMYManager
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
		$fjmy = new FJMY();
		//这里可以对新建记录进行一定的默认设置
		$fjmy->title = "纺机贸易";
		$fjmy->catid = 7;//默认值
		$fjmy->typeid = 0;//默认值
		$fjmy->n1 = $fjmy->n2 = $fjmy->n3 = '';
		$fjmy->v1 = $fjmy->v2 = $fjmy->v3 = '';
		$fjmy->amount = 0;
		$fjmy->price = 0;
		$fjmy->thumb = "";
		$fjmy->thumbs = '';
		
		$fjmy->validated = 0;
		$fjmy->editdate = $fjmy->adddate = date("Y-m-d");
		$fjmy->addtime = time();
		$fjmy->template = '';
		$fjmysh = SystemManager::getById(3);
		if ($fjmysh->value == 1)
			$fjmy->status = 2;
		else
			$fjmy->status = 3;
		return $fjmy;
	}
	
	public static function setUserInfo($fjmy, $user_id)
	{
		$member = MemberManager::getById($user_id);
		$fjmy->username = $member->username;
		$fjmy->groupid = $member->groupid;
		$fjmy->company = $member->company;
		$fjmy->truename = $member->truename;
		$fjmy->telephone = $member->telephone;
		$fjmy->mobile = $member->mobile;
		$fjmy->vip = VIPUserManager::getUserVIPLevel($user_id);
		$fjmy->email = $member->email;
		$fjmy->qq = $member->qq;
		$fjmy->wx = $member->wx;
		$fjmy->ali = $member->ali;
		$fjmy->skype = $member->skype;
		return $fjmy;
	}
	
	/*
	 * 获取fjmy的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList($paginate = false)
	{
		$fjmys = FJMY::orderby('listorder', 'desc');
		if ($paginate)
			$fjmys = $fjmys->paginate(5);
		else
			$fjmys = $fjmys->get();
		return $fjmys;
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
		$fjmy = FJMY::where('itemid', '=', $id)->first();
		return $fjmy;
	}
	
	public static function getData($fjmy)
	{
		if ($fjmy) {
			
			$fjmy->data = FJMYDataManager::getById($fjmy->itemid);
		}
		return $fjmy;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-04-19
	 */
	public static function getByCon($ConArr, $orderby = ['listorder', 'asc'], $paginate = false)
	{
		$fjmys = FJMY::query()->orderBy($orderby[0], $orderby[1]);
		$count = count($orderby);
		$i = 2;
		while (($count - $i) >= 2) {
			$fjmys->orderby($orderby[$i], $orderby[$i + 1]);
			$i += 2;
		}
		foreach ($ConArr as $key => $value) {
			if ($key == 'userid') {
				$users = MemberManager::getByCon([$key => $value]);
				$usernames = [];
				foreach ($users as $user) {
					array_push($usernames, $user->username);
				}
				
				$fjmys = $fjmys->whereIn('username', $usernames);
			} else {
				if (gettype($value) == 'array')
					$fjmys = $fjmys->whereIn($key, $value);
				else
					$fjmys = $fjmys->where($key, $value);
			}
		}
		if ($paginate)
			$fjmys = $fjmys->paginate(5);
		else
			$fjmys = $fjmys->get();
		return $fjmys;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setFJMY($fjmy, $data)
	{
		if (array_key_exists('title', $data)) {
			$fjmy->title = array_get($data, 'title');
		}
		if (array_key_exists('introduce', $data)) {
			$fjmy->introduce = array_get($data, 'introduce');
		}
		if (array_key_exists('desc', $data)) {
			$fjmy->introduce = array_get($data, 'desc');
		}
		if (array_key_exists('catid', $data)) {
			$fjmy->catid = array_get($data, 'catid');
		}
		if (array_key_exists('amount', $data)) {
			$fjmy->amount = array_get($data, 'amount');
		}
		if (array_key_exists('price', $data)) {
			$fjmy->price = array_get($data, 'price');
		}
		if (array_key_exists('address', $data)) {
			$fjmy->address = array_get($data, 'address');
		}
		if (array_key_exists('tag', $data)) {
			$fjmy->tag = array_get($data, 'tag');
		}
		if (array_key_exists('thumb', $data)) {
			$thumb = explode(',', $data['thumb']);
			$fjmy->thumb = $thumb[0];
			$fjmy->thumb1 = count($thumb) > 1 ? $thumb[1] : ($fjmy->thumb1 ? $fjmy->thumb1 : "");
			$fjmy->thumb2 = count($thumb) > 2 ? $thumb[2] : ($fjmy->thumb2 ? $fjmy->thumb2 : "");
			$fjmy->thumbs = join(',', $thumb);
		}
		if (array_key_exists('telephone', $data)) {
			$fjmy->telephone = array_get($data, 'telephone');
		}
		$fjmy->keyword = $fjmy->title . ',' . '纺机';//*****需要改动*****
		$fjmy->editor = MemberManager::getById($data['userid'])->username;
		$fjmy->editdate = date("Y-m-d");
		$fjmy->edittime = time();
		
		return $fjmy;
	}
	
	public static function createSearchInfo($fjmy)
	{
		$searchInfo = FJMYSearchManager::getByItemId($fjmy->itemid);
		$searchInfo->content = '纺机,';
		
		if ($fjmy->title)
			$searchInfo->content .= $fjmy->title . ',';
		
		$company = CompanyManager::getByUsername($fjmy->username);
		if ($company) {
			$searchInfo->content .= $company->company . ',';
		}
		
		$searchInfo->catid = $fjmy->catid;
		$cat = CategoryManager::getById($fjmy->catid);
		$searchInfo->content .= $cat->catname . ',';
		
		$tags = TagManager::getByCon(['tagid' => explode(',', $fjmy->tag)]);
		foreach ($tags as $tag) {
			$searchInfo->content .= $tag->tagname . ',';
		}
		$searchInfo->content .= FJMYDataManager::getById($fjmy->itemid)->content;
		$searchInfo->areaid = 0;
		return $searchInfo;
	}
	
	public static function getInfo($fjmy, $keys = [])
	{
		$fjmy->introduce=BanWordManager::setContent($fjmy->introduce);
		foreach ($keys as $key) {
			if ($key == 'content') {
				$fjmydata = FJMYDataManager::getById($fjmy->itemid);
				if ($fjmydata)
					$fjmy->content = BanWordManager::setContent($fjmydata->content);
				else
					$fjmy->content = '';
			} else if ($key == 'userinfo') {
				$fjmy->user = $user = MemberManager::getByUsername($fjmy->username);
				if ($user) {
					$fjmy->company = $company = CompanyManager::getById($user->userid);
					$fjmy->businesscard = BussinessCardController::getByUserid($company->userid);
				}
			} else if ($key == 'tags') {
				$fjmy->tags = array_arrange(TagManager::getByCon(['tagid' => explode(',', $fjmy->tag)]));
			} else if ($key == 'comments') {
				$fjmy->comments = array_arrange(CommentManager::getByCon(['item_mid' => [88], 'item_id' => [$fjmy->itemid]]));
				foreach ($fjmy->comments as $comment) {
					$user = MemberManager::getByUsername($comment->username);
					if ($user)
						$comment->businesscard = BussinessCardController::getByUserid($user->userid);
					$replyer = MemberManager::getByUsername($comment->replyer);
					if ($replyer) {
						$comment->replyer_businesscard = BussinessCardController::getByUserid($replyer->userid);
					}
				}
			}
		}
		return $fjmy;
	}
	
	public static function getAgreeAndFavorite($fjmy,$user){
		$fjmy->I_agree = AgreeManager::getByCon(
			['item_mid' => ['88'],
				'item_id' => [$fjmy->itemid],
				'username' => [$user->username]
			])->first() ? true : false;
		$fjmy->I_favortie = FavoriteManager::getByCon(
			['mid' => ['88'],
				'tid' => [$fjmy->itemid],
				'userid' => [$user->userid]
			]
		)->first() ? true : false;
		return $fjmy;
	}
}