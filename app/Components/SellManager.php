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
use App\Models\Sell;
use App\Models\Sell_data;
use App\Models\Sell_search;
use App\Models\Member;

class SellManager
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
		$sell = new Sell();
		//这里可以对新建记录进行一定的默认设置
		$sell->title = "供应信息";//默认值
		$sell->catid = 2;//默认值
		$sell->typeid = 0;//默认值
		$sell->n1 = $sell->n2 = $sell->n3 = '';
		$sell->v1 = $sell->v2 = $sell->v3 = '';
		$sell->amount = 0;
		$sell->price = 0;
		$sell->thumb = '';
		$sell->thumbs = '';
		
		$sell->validated = 0;
		$sell->editdate = $sell->adddate = date("Y-m-d");
		$sell->addtime = time();
		$sell->template = '';
		$sellsh = SystemManager::getById('1');
		if ($sellsh->value == 1)
			$sell->status = 2;
		else
			$sell->status = 3;
		return $sell;
	}
	
	public static function setUserInfo($sell, $user_id)
	{
		$member = MemberManager::getById($user_id);
		$sell->username = $member->username;
		$sell->groupid = $member->groupid;
		$sell->company = $member->company;
		$sell->truename = $member->truename;
		$sell->telephone = $member->telephone;
		$sell->mobile = $member->mobile;
		$sell->vip = VIPUserManager::getUserVIPLevel($user_id);
		$sell->email = $member->email;
		$sell->qq = $member->qq;
		$sell->wx = $member->wx;
		$sell->ali = $member->ali;
		$sell->skype = $member->skype;
		return $sell;
	}
	
	/*
	 * 获取sell的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList($paginate = false)
	{
		$sells = Sell::orderby('listorder', 'desc');
		if ($paginate)
			$sells = $sells->paginate(5);
		else
			$sells = $sells->get();
		return $sells;
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
		$sell = Sell::where('itemid', '=', $id)->first();
		return $sell;
	}
	
	public static function getData($sell)
	{
		if ($sell) {
			
			$sell->data = SellDataManager::getById($sell->itemid);
		}
		return $sell;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-04-19
	 */
	public static function getByCon($ConArr, $orderby = ['listorder', 'asc'], $paginate = true)
	{
		$sells = Sell::query()->orderby($orderby[0], $orderby[1]);
		$count = count($orderby);
		$i = 2;
		while (($count - $i) >= 2) {
			$sells->orderby($orderby[$i], $orderby[$i + 1]);
			$i += 2;
		}
		foreach ($ConArr as $key => $value) {
			if ($key == 'userid') {
				$users = MemberManager::getByCon([$key => $value]);
				$usernames = [];
				foreach ($users as $user) {
					array_push($usernames, $user->username);
				}
				
				$sells = $sells->whereIn('username', $usernames);
			} else {
				if (gettype($value) == 'array')
					$sells = $sells->whereIn($key, $value);
				else
					$sells = $sells->where($key, $value);
			}
		}
		if ($paginate)
			$sells = $sells->paginate(5);
		else
			$sells = $sells->get();
		return $sells;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setSell($sell, $data)
	{
		if (array_key_exists('title', $data)) {
			$sell->title = array_get($data, 'title');
		}
		if (array_key_exists('introduce', $data)) {
			$sell->introduce = array_get($data, 'introduce');
		}
		if (array_key_exists('desc', $data)) {
			$sell->introduce = array_get($data, 'desc');
		}
		if (array_key_exists('catid', $data)) {
			$sell->catid = array_get($data, 'catid');
		}
		if (array_key_exists('amount', $data)) {
			$sell->amount = array_get($data, 'amount');
		}
		if (array_key_exists('price', $data)) {
			$sell->price = array_get($data, 'price');
		}
		if (array_key_exists('address', $data)) {
			$sell->address = array_get($data, 'address');
		}
		if (array_key_exists('tag', $data)) {
			$sell->tag = array_get($data, 'tag');
		}
		if (array_key_exists('thumb', $data)) {
			$data['thumb'] = explode(',', $data['thumb']);
			if (count($data['thumb']) > 0) {
				$sell->thumb = $data['thumb'][0];
				$sell->thumb1 = count($data['thumb']) > 1 ? $data['thumb'][1] : ($sell->thumb1 ? $sell->thumb1 : "");
				$sell->thumb2 = count($data['thumb']) > 2 ? $data['thumb'][2] : ($sell->thumb2 ? $sell->thumb2 : "");
				$sell->thumbs = join(',', $data['thumb']);
			}
		}
		if (array_key_exists('telephone', $data)) {
			$sell->telephone = array_get($data, 'telephone');
		}
		$sell->keyword = $sell->title . ',' . '供应';//*****需要改动*****
		$sell->editor = MemberManager::getById($data['userid'])->username;
		$sell->editdate = date("Y-m-d");
		$sell->edittime = time();
		if(array_key_exists('formId',$data)){
			$sell->formId = array_get($data, 'formId');
		}
		
		return $sell;
	}
	
	public static function createSearchInfo($sell)
	{
		$searchInfo = SellSearchManager::getByItemId($sell->itemid);
		$searchInfo->content = '供应,';
		
		if ($sell->title)
			$searchInfo->content .= $sell->title . ',';
		
		$company = CompanyManager::getByUsername($sell->username);
		if ($company) {
			$searchInfo->content .= $company->company . ',';
		}
		
		$searchInfo->catid = $sell->catid;
		$cat = CategoryManager::getById($sell->catid);
		$searchInfo->content .= $cat->catname . ',';
		
		$tags = TagManager::getByCon(['tagid' => explode(',', $sell->tag)]);
		foreach ($tags as $tag) {
			$searchInfo->content .= $tag->tagname . ',';
		}
		$searchInfo->content .= SellDataManager::getById($sell->itemid)->content;
		$searchInfo->areaid = 0;
		return $searchInfo;
	}
	
	public static function getInfo($sell, $keys = [])
	{
		$sell->introduce = BanWordManager::setContent($sell->introduce);
		foreach ($keys as $key) {
			if ($key == 'content') {
				$selldata = SellDataManager::getById($sell->itemid);
				if ($selldata)
					$sell->content = BanWordManager::setContent($selldata->content);
				else
					$sell->content = '';
			} else if ($key == 'userinfo') {
				$sell->user = $user = MemberManager::getByUsername($sell->username);
				if ($user) {
					$sell->company = $company = CompanyManager::getById($user->userid);
					$sell->businesscard = BussinessCardController::getByUserid($company->userid);
				}
			} else if ($key == 'tags') {
				$sell->tags = array_arrange(TagManager::getByCon(['tagid' => explode(',', $sell->tag)]));
			} else if ($key == 'comments') {
				$sell->comments = array_arrange(CommentManager::getByCon(['item_mid' => [5], 'item_id' => [$sell->itemid]]));
				foreach ($sell->comments as $comment) {
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
		return $sell;
	}
	
	public static function getAgreeAndFavorite($sell, $user)
	{
		$sell->I_agree = AgreeManager::getByCon(
			['item_mid' => ['5'],
				'item_id' => [$sell->itemid],
				'username' => [$user->username]
			])->first() ? true : false;
		$sell->I_favortie = FavoriteManager::getByCon(
			['mid' => ['5'],
				'tid' => [$sell->itemid],
				'userid' => [$user->userid]
			]
		)->first() ? true : false;
		return $sell;
	}
	
	public static function CountInfosByUsername($username, $today = false)
	{
		if ($today) {
			$time0 = $today = strtotime(date("Y-m-d"), time());
			$sells = Sell::where('username', $username)->where("addtime", ">=", $time0)->count();
//			$buys = Buy::where('username', $username)->where("addtime",">=",$time0)->count();
//			$fjmys = FJMY::where('username', $username)->where("addtime",">=",$time0)->count();
		} else {
			$sells = Sell::where('username', $username)->count();
//			$buys = Buy::where('username', $username)->count();
//			$fjmys = FJMY::where('username', $username)->count();
		}
		return $sells;
	}
}