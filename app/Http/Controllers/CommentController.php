<?php

namespace App\Http\Controllers;


use App\Components\AgreeManager;
use App\Components\ArticleManager;
use App\Components\BuyManager;
use App\Components\CommentManager;
use App\Components\CompanyManager;
use App\Components\FavoriteManager;
use App\Components\FJMYManager;
use App\Components\MemberManager;
use App\Components\SellManager;
use App\Components\TestManager;
use App\Models\Member;
use App\Models\Test;
use Illuminate\Http\Request;


class CommentController extends Controller
{
	
	//评论，开发中
	/*
	 *
	 * mid=6已完成，等待补完mid=5
	 *
	 * 暂不支持回复、引用
	 *
	 * 2018/7/12
	 */
	public function comment(Request $request)
	{
		$data = $request->all();
		$me = MemberManager::getById($data['userid']);
		if (checkParam($data, ['item_mid', 'item_id', 'content'])) {
			$comment = CommentManager::createObject();
			$comment = CommentManager::setComment($comment, $data);
			$comment = CommentManager::setUserInfo($comment, $me);
			
			$item = null;
			//获得被评论的信息
			if ($data['item_mid'] == 5) {
				//供应
				$item = SellManager::getById($data['item_id']);
//				$item=5;
			} elseif ($data['item_mid'] == 6) {
				//求购
				$item = BuyManager::getById($data['item_id']);
			} elseif ($data['item_mid'] == 21) {
				//资讯
				$item = ArticleManager::getById($data['item_id']);
			} elseif ($data['item_mid'] == 88) {
				//求购
				$item = FJMYManager::getById($data['item_id']);
			}
			if ($item) {
				$comment = CommentManager::setItemInfo($comment, $item);
			} else {
				return ApiResponse::makeResponse(false, "参数错误", ApiResponse::MISSING_PARAM);
			}
			
			$comment->save();
			$user = MemberManager::getByUsername($comment->username);
			if ($user)
				$comment->businesscard = BussinessCardController::getByUserid($user->userid,$me);
			return ApiResponse::makeResponse(true, $comment, ApiResponse::SUCCESS_CODE);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
		
	}
	
	
	/*
	 * 点赞功能
	 *
	 * mid=6已完成，等待补完mid=5
	 *
	 * 2018/7/12
	 */
	public static function agree(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		//检验参数
		if (checkParam($data, ['item_mid', 'item_id'])) {
			$ret = "请求成功";
			if (AgreeManager::getByCon(
				['item_mid' => [$data['item_mid']],
					'item_id' => [$data['item_id']],
					'username' => [$user->username]
				])->first()) {
				return ApiResponse::makeResponse(false, "您已经点过赞了", ApiResponse::MISSING_PARAM);
			}
			$item = null;
			//获得被评论的信息
			if ($data['item_mid'] == 2) {
				$item=CompanyManager::getById($data['item_id']);
			}
			elseif ($data['item_mid'] == 5) {
				//供应
				$item = SellManager::getById($data['item_id']);
//				$item=5;
			} elseif ($data['item_mid'] == 6) {
				//求购
				$item = BuyManager::getById($data['item_id']);
			} elseif ($data['item_mid'] == 21) {
				//资讯
				$item = ArticleManager::getById($data['item_id']);
			} elseif ($data['item_mid'] == 88) {
				//求购
				$item = FJMYManager::getById($data['item_id']);
			}
			if ($item) {
				$agree = AgreeManager::createObject();
				$agree = AgreeManager::setAgree($agree, $data, $item);
				$agree = AgreeManager::setUserInfo($agree, $user);
				$agree->addtime = time();
				$item->agree++;
				$agree->save();
				$item->save();
				
			} else {
				return ApiResponse::makeResponse(false, "参数错误", ApiResponse::MISSING_PARAM);
			}
			return ApiResponse::makeResponse(true, $item, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function agreeStatus(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		//检验参数
		if (checkParam($data, ['items'])) {
			$ret = [];
			$items = explode(',', $data['items']);
			foreach ($items as $item) {
				array_push($ret,
					AgreeManager::getByCon(
						['item_mid' => [explode(':', $item)[0]],
							'item_id' => [explode(':', $item)[1]],
							'username' => [$user->username]
						]
					)->first() ? true : false);
			}
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function favorite(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		
		//检验参数
		if (checkParam($data, ['mid', 'tid'])) {
			$ret = "收藏成功";
			$item = null;
			//获得被评论的信息
			if ($data['mid'] == 2) {
				$item=CompanyManager::getById($data['tid']);
			}
			elseif ($data['mid'] == 5) {
				//供应
				$item = SellManager::getById($data['tid']);
//				$item=5;
			} elseif ($data['mid'] == 6) {
				//求购
				$item = BuyManager::getById($data['tid']);
			} elseif ($data['mid'] == 21) {
				//资讯
				$item = ArticleManager::getById($data['tid']);
			} elseif ($data['mid'] == 88) {
				//求购
				$item = FJMYManager::getById($data['tid']);
			}
			
			if ($item) {
				$favorite = FavoriteManager::getByCon(['mid' => $data['mid'], 'tid' => $data['tid'], 'userid' => $data['userid']])->first();
				
				if (array_key_exists('cancle', $data)) {
					if ($favorite) {
						$favorite->delete();
						$item->favorite--;
						$item->save();
						return ApiResponse::makeResponse(true, "取消成功", ApiResponse::SUCCESS_CODE);
					} else {
						return ApiResponse::makeResponse(false, "没有关注记录", ApiResponse::UNKNOW_ERROR);
					}
				}
				else if($favorite){
					return ApiResponse::makeResponse(false, "请不要重复收藏", ApiResponse::UNKNOW_ERROR);
				}
				$favorite = $favorite ? $favorite : FavoriteManager::createObject();
				$favorite = FavoriteManager::setFavorite($favorite, $data);
				$item->favorite++;
				$favorite->save();
				$item->save();
			} else {
				return ApiResponse::makeResponse(false, "参数错误", ApiResponse::MISSING_PARAM);
			}
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function favoriteStatus(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		//检验参数
		if (checkParam($data, ['items'])) {
			$ret = [];
			$items = explode(',', $data['items']);
			foreach ($items as $item) {
				array_push($ret,
					FavoriteManager::getByCon(
						['mid' => [explode(':', $item)[0]],
							'tid' => [explode(':', $item)[1]],
							'userid' => [$user->userid]
						]
					)->first() ? true : false);
			}
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function myFavorite(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		$con = ['userid' => [$data['userid']]];
		if (array_key_exists('mid', $data)) {
			$con['mid'] = [$data['mid']];
		}
		$myFavorites = FavoriteManager::getByCon($con, true,['itemid', 'desc']);
		foreach ($myFavorites as $favorite) {
			switch ($favorite->mid) {
				case '2':
					$item = BussinessCardController::getByUserid($favorite->tid,$user);
					$favorite->item = $item;
					break;
				case '5':
					$item = SellManager::getById($favorite->tid);
					if ($item) {
						$item = SellManager::getInfo($item, ['content', 'userinfo', 'tags']);
						$item=SellManager::getAgreeAndFavorite($item,$user);
					}
					$favorite->item = $item;
					break;
				case '6':
					$item = BuyManager::getById($favorite->tid);
					if ($item) {
						$item = BuyManager::getInfo($item, ['content', 'userinfo', 'tags']);
						$item=BuyManager::getAgreeAndFavorite($item,$user);
					}
					$favorite->item = $item;
					break;
				case '21':
					$favorite->item = ArticleManager::getById($favorite->tid);
					break;
				case '88':
					$item = FJMYManager::getById($favorite->tid);
					if ($item) {
						$item = FJMYManager::getInfo($item, ['content', 'userinfo', 'tags']);
						$item=FJMYManager::getAgreeAndFavorite($item,$user);
					}
					$favorite->item = $item;
					break;
				default:
					break;
			}
		}
		return ApiResponse::makeResponse(true, $myFavorites, ApiResponse::SUCCESS_CODE);
	}
	
	public static function reply(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		//检验参数
		if (checkParam($data, ['itemid', 'reply'])) {
			$comment = CommentManager::getById($data['itemid']);
			if ($comment->item_username != $user->username) {
				return ApiResponse::makeResponse(false, "只能回复自己发布的信息!", ApiResponse::UNKNOW_ERROR);
			}
			
			$comment->reply = $data['reply'];
			$comment->replytime = time();
			$comment->replyer = $user->username;
			$comment->save();
			
			$ret = "回复成功";
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
}
