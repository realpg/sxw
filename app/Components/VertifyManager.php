<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/2
 * Time: 14:23
 */

namespace App\Components;


use App\Models\Vertify;
use LaraMall\AlidySms\Facades\Sms;

class VertifyManager
{
	/*
	   * 生成验证码
	   *
	   * By TerryQi
	   */
	public static function doVertify($phonenum)
	{
		$vertify_code = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);  //生成4位验证码
		$vertify = new Vertify();
		$vertify->addtime = time();
		$vertify->status = 0;//待发送状态
		$vertify->phonenum = $phonenum;
		$vertify->code = $vertify_code;
		$vertify->save();
		/*
		 * 预留，需要触发短信端口进行验证码下发
		 */
		if ($vertify) {
			return self::sendVerification($vertify);
		}
		return false;
	}
	
	//旧版，已弃用
	public static function sendVerification0($vertify)
	{
		$phonenum = $vertify->phonenum;
		$content = "您的验证码为：" . $vertify->code . "，30分钟内有效，请尽快输入。";
		$ret = MobileMessageManager::sendMessage($phonenum, $content);
		if (strpos($ret, "success") == 0) {
			$vertify->status = 3;//发送成功
			$vertify->err = $ret;
			$vertify->save();
			return true;
		} else {
			$vertify->status = 2;//失效
			$vertify->err = $ret;
			$vertify->save();
			return false;
		}
		
	}
	
	public static function sendVerification($vertify)
	{
		$phone = $vertify->phonenum;
		$signName="中国纱线网";
		$templateCode = "SMS_111785778";
		$content = $vertify->code;
		
		return Sms::put('phone', $phone)//接受短信的手机号码
		->put('signName',$signName)  //短信签名
		->put('templateCode', $templateCode)// 短信模板编号
//		->put('field', $field)//短信模板中的变量字段
		->put('content', $content)//短信中变量的内容 （也就是验证码)
		->send(); //发送短信;
	}
	
	/*
	 * 校验验证码
	 *
	 * By TerryQi
	 *
	 * 2017-11-28
	 */
	public static function judgeVertifyCode($phonenum, $vertify_code)
	{
		$vertify = Vertify::where('phonenum', $phonenum)
			->where('code', $vertify_code)->where('status', '3')->first();
		if ($vertify) {
			//验证码置为失效
			$vertify->status = '2';
			$vertify->save();
			return true;
		} else {
			return false;
		}
	}
	
}