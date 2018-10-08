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
use App\Models\Buy;
use App\Models\Buy_data;
use App\Models\Buy_search;
use App\Models\Member;

class BuyManager
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
		$buy = new Buy();
		//这里可以对新建记录进行一定的默认设置
		$buy->title = "求购信息";//默认值
		$buy->catid = 5;//默认值
		$buy->typeid = 0;//默认值
		$buy->n1 = $buy->n2 = $buy->n3 = '';
		$buy->v1 = $buy->v2 = $buy->v3 = '';
		$buy->amount = 0;
		$buy->price = 0;
		$buy->thumb = '';
		$buy->thumbs = '';
		$buy->validated = 0;
		$buy->editdate = $buy->adddate = date("Y-m-d");
		$buy->addtime = time();
		$buy->template = '';
		$buysh = SystemManager::getById('2');
		if ($buysh->value == 1)
			$buy->status = 2;
		else
			$buy->status = 3;
		$buy->pack = '';
		return $buy;
	}
	
	public static function setUserInfo($buy, $user_id)
	{
		$member = MemberManager::getById($user_id);
		$buy->username = $member->username;
		$buy->groupid = $member->groupid;
		$buy->company = $member->company;
		$buy->truename = $member->truename;
		$buy->telephone = $member->telephone;
		$buy->mobile = $member->mobile;
		$buy->vip = VIPUserManager::getUserVIPLevel($user_id);
		$buy->email = $member->email;
		$buy->qq = $member->qq;
		$buy->wx = $member->wx;
		$buy->ali = $member->ali;
		$buy->skype = $member->skype;
		return $buy;
	}
	
	/*
	 * 获取buy的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList($paginate = false)
	{
		$buys = Buy::orderby('listorder', 'desc');
		if ($paginate)
			$buys = $buys->paginate(5);
		else
			$buys = $buys->get();
		return $buys;
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
		$buy = Buy::where('itemid', '=', $id)->first();
		return $buy;
	}
	
	public static function getData($buy)
	{
		if ($buy) {
			
			$buy->data = BuyDataManager::getById($buy->itemid);
		}
		return $buy;
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
		$buys = Buy::orderby($orderby[0], $orderby[1]);
		$count = count($orderby);
		$i = 2;
		while (($count - $i) >= 2) {
			$buys->orderby($orderby[$i], $orderby[$i + 1]);
			$i += 2;
		}
		foreach ($ConArr as $key => $value) {
			if ($key == 'userid') {
				$users = MemberManager::getByCon([$key => $value]);
				$usernames = [];
				foreach ($users as $user) {
					array_push($usernames, $user->username);
				}
				
				$buys = $buys->whereIn('username', $usernames);
			} else {
				$buys = $buys->whereIn($key, $value);
			}
		}
		if ($paginate)
			$buys = $buys->paginate(5);
		else
			$buys = $buys->get();
		return $buys;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setBuy($buy, $data)
	{
		if (array_key_exists('title', $data)) {
			$buy->title = array_get($data, 'title');
		}
		if (array_key_exists('introduce', $data)) {
			$buy->introduce = array_get($data, 'introduce');
		}
		if (array_key_exists('desc', $data)) {
			$buy->introduce = array_get($data, 'desc');
		}
		if (array_key_exists('catid', $data)) {
			$buy->catid = array_get($data, 'catid');
		}
		if (array_key_exists('amount', $data)) {
			$buy->amount = array_get($data, 'amount');
		}
		if (array_key_exists('price', $data)) {
			$buy->price = array_get($data, 'price');
		}
		if (array_key_exists('address', $data)) {
			$buy->address = array_get($data, 'address');
		}
		if (array_key_exists('tag', $data)) {
			$buy->tag = array_get($data, 'tag');
		}
		if (array_key_exists('thumb', $data)) {
			$data['thumb'] = explode(',', $data['thumb']);
			$buy->thumb = $data['thumb'][0];
			$buy->thumb1 = count($data['thumb']) > 1 ? $data['thumb'][1] : ($buy->thumb1 ? $buy->thumb1 : "");
			$buy->thumb2 = count($data['thumb']) > 2 ? $data['thumb'][2] : ($buy->thumb2 ? $buy->thumb2 : "");
			$buy->thumbs = join(',', $data['thumb']);
		}
		if (array_key_exists('telephone', $data)) {
			$buy->telephone = array_get($data, 'telephone');
		}
		$buy->keyword = $buy->title . ',' . '求购';//*****需要改动*****
		$buy->editor = MemberManager::getById($data['userid'])->username;
		$buy->editdate = date("Y-m-d");
		$buy->edittime = time();
		
		return $buy;
	}
	
	public static function createSearchInfo($buy)
	{
		$searchInfo = BuySearchManager::getByItemId($buy->itemid);
		$searchInfo->content = '求购,';
		
		if ($buy->title)
			$searchInfo->content .= $buy->title . ',';
		
		$company = CompanyManager::getByUsername($buy->username);
		if ($company) {
			$searchInfo->content .= $company->company . ',';
		}
		
		$searchInfo->catid = $buy->catid;
		$cat = CategoryManager::getById($buy->catid);
		$searchInfo->content .= $cat->catname . ',';
		
		$tags = TagManager::getByCon(['tagid' => explode(',', $buy->tag)]);
		foreach ($tags as $tag) {
			$searchInfo->content .= $tag->tagname . ',';
		}
		$searchInfo->content .= BuyDataManager::getById($buy->itemid)->content;
		$searchInfo->areaid = 0;
		return $searchInfo;
	}
	
	public static function getInfo($buy, $keys = [])
	{
		$buy->introduce=BanWordManager::setContent($buy->introduce);
		foreach ($keys as $key) {
			if ($key == 'content') {
				$buydata = BuyDataManager::getById($buy->itemid);
				if ($buydata)
					$buy->content = BanWordManager::setContent($buydata->content);
				else
					$buy->content = '';
			} else if ($key == 'userinfo') {
				$buy->user = $user = MemberManager::getByUsername($buy->username);
				if ($user) {
					$buy->company = $company = CompanyManager::getById($user->userid);
					$buy->businesscard = BussinessCardController::getByUserid($company->userid);
				}
			} else if ($key == 'tags') {
				$buy->tags = array_arrange(TagManager::getByCon(['tagid' => explode(',', $buy->tag)]));
			} else if ($key == 'comments') {
				$buy->comments = array_arrange(CommentManager::getByCon(['item_mid' => [6], 'item_id' => [$buy->itemid]]));
				foreach ($buy->comments as $comment) {
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
		return $buy;
	}
	
	public static function getAgreeAndFavorite($buy,$user){
		$buy->I_agree = AgreeManager::getByCon(
			['item_mid' => ['6'],
				'item_id' => [$buy->itemid],
				'username' => [$user->username]
			])->first() ? true : false;
		$buy->I_favortie = FavoriteManager::getByCon(
			['mid' => ['6'],
				'tid' => [$buy->itemid],
				'userid' => [$user->userid]
			]
		)->first() ? true : false;
		return $buy;
	}
}