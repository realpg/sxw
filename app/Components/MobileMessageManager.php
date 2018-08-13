<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/8/13
 * Time: 9:39
 */

namespace App\Components;


class MobileMessageManager
{
	//请求地址
	private static $url = 'http://api.cxton.com:8080/eums/utf8/send_strong.do';
	//帐号
	private static $name = 'shaxian';
	//md5密码
	private static $md5password = 'afdd0b4ad2ec172c586e2150770fbf9e';
	// http请求字符编码
	public static $CONTENT_TYPE = "application/x-www-form-urlencoded";
	// http提交数据方式
	public static $ACCEPT = "application/x-www-form-urlenconded";
	
	public static function sendMessage($dest, $content)
	{
		date_default_timezone_set("Asia/Shanghai");
		$seed = date('YmdHis');
		$key = md5(self::$md5password . $seed);
		$content = "【纱线网】" . $content;
		
		$body = [
			'name' => self::$name,
			'seed' => $seed,
			'key' => $key,
			'dest' => $dest,
			'content' => $content
		];
		$result = self::post($body);
		return $result;
	}
	
	//post方法
	public static function post($body)
	{
		// 构造请求数据
		$url = self::$url;
		$headers = self::createHeaders();
		
		// 拼接字符串
		$fields_string = "";
		foreach ($body as $key => $value) {
			$fields_string .= $key . '=' . $value . '&';
		}
		rtrim($fields_string, '&');
		// 提交请求
		$con = curl_init();
		curl_setopt($con, CURLOPT_URL, $url);
		curl_setopt($con, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($con, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($con, CURLOPT_HEADER, 0);
		curl_setopt($con, CURLOPT_POST, 1);
		curl_setopt($con, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($con, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($con, CURLOPT_POSTFIELDS, $fields_string);
		$result = curl_exec($con);
		curl_close($con);
		return "" . $result;
	}
	
	// 创建请求头
	public static function createHeaders()
	{
		$headers = array('Content-type: ' . self::$CONTENT_TYPE, 'Accept: ' . self::$ACCEPT);
		return $headers;
	}
	
}