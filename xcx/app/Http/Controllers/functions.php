<?php
/**
 * 工具函数
 * 公共方法
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/21 0021
 * Time: 21:17
 */
//function p($var = '')
//{
//	if (is_object($var) || is_array($var)) {
//		echo "<pre>";
//		print_r($var);
//		echo "</pre>";
//	} else {
//		echo $var;
//	}
//	die;
//}

//function success($message, $url = '', $time = 3)
//{
//	return view('common.jump')->with([
//		'message' => $message,
//		'url' => $url,
//		'jumpTime' => 3
//	]);
//}

function error($message, $url = '', $time = 3)
{
	return success($message, $url, $time);
}

function dpassword($password, $salt)
{
	return md5((is_md5($password) ? md5($password) : md5(md5($password))) . $salt);
}

function randomSalt($len = 8,$chars=null)
{
	if (is_null($chars)){
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	}
	$random_max=strlen($chars);
	$salt='';
	for($i=0;$i<$len;$i++){
		$salt.=$chars[mt_rand(0.,$random_max)];
	}
	return $salt;
}
