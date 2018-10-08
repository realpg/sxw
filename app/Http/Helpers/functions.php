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

function randomSalt($len = 8, $chars = null)
{
	if (is_null($chars)) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	}
	$random_max = strlen($chars) - 1;
	$salt = '';
	for ($i = 0; $i < $len; $i++) {
		$salt .= $chars[mt_rand(0., $random_max)];
	}
	return $salt;
}

function getTokenLifetimeTimestemp()
{
	$now = time();
	$nextDay = intval(($now / 86400) + 1) * 86400 - 28800;
	return $nextDay;
}

//检查参数
function checkParam($Array, $params = [''])
{
	foreach ($params as $param) {
		if (!array_key_exists($param, $Array)) {
			return false;
		} elseif (array_get($Array, $param) == null) {
			return false;
		}
	}
	return true;
}

function getPRCdate($timestemp, $format = "Y-m-d H:i:s")
{
	return date($format, $timestemp + 28800);
}

//将array整理，index变为0，1，2.....
function array_arrange($arr)
{
	$arr_arrange = [];
	foreach ($arr as $key => $value) {
		array_push($arr_arrange, $value);
	}
	return $arr_arrange;
}

function downloadImage($url, $path = '')
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	$file = curl_exec($ch);
	curl_close($ch);
	$filename = pathinfo($url, PATHINFO_BASENAME);
	$resource = fopen($path . $filename, 'a');
	fwrite($resource, $file);
	fclose($resource);
	return $path . $filename;
}

function downloadImg($url)
{
	
	$header = array('User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:45.0) Gecko/20100101 Firefox/45.0', 'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3', 'Accept-Encoding: gzip, deflate',);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
	curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
	$data = curl_exec($curl);
	$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);
	if ($code == 200) {
		//把URL格式的图片转成base64_encode格式的！
		
		$imgBase64Code = "data:image/jpeg;base64," . base64_encode($data);
	} else {
		return null;
	}
	$img_content = $imgBase64Code;
	//图片内容
	// //echo $img_content;exit;
	if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $img_content, $result)) {
		$type = $result[2];
		//得到图片类型png?jpg?gif?
//				$new_file = time().".";
		$path = storage_path('app/public/' . date('Y-m-d') . '/download');
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}
		$new_file = $path . '/' . time() . ".{$type}";
		if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $img_content)))) {
//			Log::info('新文件保存成功：' . $new_file);
			$ext = $type;
			return $new_file;
		}
	}
	return null;
}

function makePassword($password,$salt){
	return md5((preg_match("/^[a-f0-9]{32}$/", $password) ? md5($password) : md5(md5($password))).$salt);
}