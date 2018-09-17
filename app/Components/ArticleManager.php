<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Article;
use App\Models\Article_data;
use App\Models\Article_search;
use App\Models\Member;

class ArticleManager
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
		$article = new Article();
		//这里可以对新建记录进行一定的默认设置
		$article->catid = 2;//默认值
		$article->typeid = 0;//默认值
		$article->n1 = $article->n2 = $article->n3 = '';
		$article->v1 = $article->v2 = $article->v3 = '';
		$article->thumbs = '';
		$article->vip = 0;
		$article->validated = 0;
		$article->editdate = $article->adddate = date("Y-m-d");
		$article->addtime = time();
		$article->template = '';
		$articlesh = SystemManager::getById('2');
		if ($articlesh->value == 1)
			$article->status = 2;
		else
			$article->status = 3;
		$article->pack = '';
		
		return $article;
	}
	
	public static function setUserInfo($article, $user_id)
	{
		$member = MemberManager::getById($user_id);
		$article->username = $member->username;
		$article->groupid = $member->groupid;
		$article->company = $member->company;
		$article->truename = $member->truename;
		$article->telephone = $member->telephone;
		$article->mobile = $member->mobile;
		$article->address = $member->address ? $member->address : "未知";
		$article->email = $member->email;
		$article->qq = $member->qq;
		$article->wx = $member->wx;
		$article->ali = $member->ali;
		$article->skype = $member->skype;
		return $article;
	}
	
	/*
	 * 获取article的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$articles = Article::orderby('itemid', 'desc')->paginate(5);
		return $articles;
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
		$article = Article::where('itemid', '=', $id)->first();
		return $article;
	}
	
	public static function getData($article)
	{
		if ($article) {
			
			$article->data = ArticleDataManager::getById($article->itemid);
		}
		return $article;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-04-19
	 */
	public static function getByCon($ConArr, $orderby = ['itemid', 'desc'])
	{
		$articles = Article::orderby($orderby['0'], $orderby['1']);
		foreach ($ConArr as $key => $value) {
			if ($key == 'userid') {
				$users = MemberManager::getByCon([$key => $value]);
				$usernames = [];
				foreach ($users as $user) {
					array_push($usernames, $user->username);
				}
				
				$articles = $articles->whereIn('username', $usernames);
			} else {
				$articles = $articles->whereIn($key, $value);
			}
		}
		$articles = $articles->paginate(5);
		return $articles;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setArticle($article, $data)
	{
		if (array_key_exists('title', $data)) {
			$article->title = array_get($data, 'title');
		}
		if (array_key_exists('introduce', $data)) {
			$article->introduce = array_get($data, 'introduce');
		}
		if (array_key_exists('catid', $data)) {
			$article->catid = array_get($data, 'catid');
		}
		if (array_key_exists('amount', $data)) {
			$article->amount = array_get($data, 'amount');
		}
		if (array_key_exists('price', $data)) {
			$article->price = array_get($data, 'price');
		}
		if (array_key_exists('tag', $data)) {
			$article->tag = array_get($data, 'tag');
		}
		if (array_key_exists('thumb', $data)) {
			$article->thumb = array_get($data, 'thumb');
		}
		if (array_key_exists('telephone', $data)) {
			$article->telephone = array_get($data, 'telephone');
		}
		$article->keyword = $article->title . ',' . '求购' . '求购分类';//*****需要改动*****
		$article->editor = MemberManager::getById($data['userid'])->username;
		$article->editdate = date("Y-m-d");
		$article->edittime = time();
		
		return $article;
	}
	
//	public static function createSearchInfo($article)
//	{
//		$searchInfo = ArticleSearchManager::getByItemId($article->itemid);
//		$searchInfo->content = '求购，';
//
//		$searchInfo->content .= $article->title . ',';
//
//		$searchInfo->catid = $article->catid;
//		$cat = CategoryManager::getById($article->catid);
//		$searchInfo->content .= $cat->catname . ',';
//
//		return $searchInfo;
//	}
}