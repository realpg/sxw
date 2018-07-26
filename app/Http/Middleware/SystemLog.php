<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/7/9
 * Time: 11:45
 */

namespace App\Http\Middleware;

use App\Components\XCXLogManager;
use Closure;
use Illuminate\Http\Request;

class SystemLog
{
	function handle($request, Closure $next, $guard = null)
	{
		$ip=$this->get_client_ip_from_ns();
		$param=json_encode($request->all());
		$url = $request->url();
		$method = $request->method();
		$xcx_log=XCXLogManager::log($url,$method,$ip,$param);
		return $next($request);
	}
	
	/*
 * 函数功能: 获取客户端的真实IP地址
 *
 * 为什么要用这个函数?
 * 因为我们线上Web服务器绝大部分都处于Netscaler(简称NS)后面，客户端访问的地址统一由NS调度
 * 由NS调度的访问其实就是NS做了一层代理, 这期间就有一个问题, 因为真实的地址是内部IP请求的
 * 当我们的应用去请获取 $_SERVER["REMOTE_ADDR"] 的时候, 得到的就是 NS 的内部 IP, 获取不了
 * 真正的客户端 IP 地址.
 *
 * 当请求经过 NS 调度之后, NS 会把客户端的真实 IP 附加到 HTTP_CLIENT_IP 后，我们要提取的就
 * 是这个地址.
 *
 * 如测试数据:
 * [HTTP_CLIENT_IP] => 192.168.2.251, 192.168.3.252, 218.82.113.110
 * 这条信息是我测试的结果, 前面两个 IP 是我伪造的, 最后那个 IP 才是我真实的地址.
 *
 * 同样我也测试过通过代理的数据
 * [HTTP_X_FORWARDED_FOR] => 192.168.2.179, 123.45.67.78 64.191.50.54
 * 前面两个IP是我伪造的, 最后面那个地址才是 proxy 的真实地址
 *
 * 提醒:
 * HTTP_CLIENT_IP, HTTP_X_FORWARDED_FOR 都可以在客户端伪造, 不要轻易直接使用这两个值, 因为
 * 恶意用户可以在里面输入PHP代码, 或者像伪造 N 个', 让你的程序执行有问题, 如果要直接使用这
 * 两个值的时候最简单的应该判断一下长度(最长15位), 或用正则匹配一下是否是一个有效的IP地址
 *
 * 参数:
 *
 * @param string $proxy_override, [true|false], 是否优先获取从代理过来的地址
 * @return string
 *
 */
	function get_client_ip_from_ns($proxy_override = false)
	{
		if ($proxy_override) {
			/* 优先从代理那获取地址或者 HTTP_CLIENT_IP 没有值 */
			$ip = empty($_SERVER["HTTP_X_FORWARDED_FOR"]) ? (empty($_SERVER["HTTP_CLIENT_IP"]) ? NULL : $_SERVER["HTTP_CLIENT_IP"]) : $_SERVER["HTTP_X_FORWARDED_FOR"];
		} else {
			/* 取 HTTP_CLIENT_IP, 虽然这个值可以被伪造, 但被伪造之后 NS 会把客户端真实的 IP 附加在后面 */
			$ip = empty($_SERVER["HTTP_CLIENT_IP"]) ? NULL : $_SERVER["HTTP_CLIENT_IP"];
		}
		
		if (empty($ip)) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		/* 真实的IP在以逗号分隔的最后一个, 当然如果没用代理, 没伪造IP, 就没有逗号分离的IP */
		if ($p = strrpos($ip, ",")) {
			$ip = substr($ip, $p + 1);
		}
		
		return trim($ip);
	}
	
	/*
	 * 检查客户端从什么地方过来的请求
	 *
	 * <code>
	 *    // 严格检查此页面来源中域名必须包含 .dod.com
	 *    if (!check_client_referer(true, '.dod.com')) {
	 *       die('非法提交的数据');
	 *    }
	 *    // 松散检查来源url中必须包含.51.com
	 *    if (!check_client_referer()) {
	 *       die('非法提交的数据');
	 *    }
	 * </code>
	 *
	 * @param bool   $restrict  是否进行严格的查检, 此方式为用正则对host进行匹配
	 * @param string $allow       允许哪些 referer 过来请求
	 * @return true / false       在允许的列表内返回true
	 *
	 */
	function check_client_referer($restrict = true, $allow = '.xx5.com')
	{
		$referer = isset($_SERVER['HTTP_REFERER']) ? trim($_SERVER['HTTP_REFERER']) : null;
		if (empty($referer)) {
			return true;
		} /* 空的 referer 直接允许 */
		
		if ($restrict) {
			
			/* 更加严格的查检, 此值为true时, allow 可以输入正则来匹配 */
			$url = parse_url($referer);
			/* host 为空时直接返回不false */
			if (empty($url['host'])) {
				return false;
			}
			
			/* 将正则中的.替换掉为\.真正匹配.再进行匹配 */
			$allow = '/' . str_replace('.', '\.', $allow) . '/';
			return 0 < preg_match($allow, $url['host']);
		}
		
		return false !== strpos($referer, $allow);
	}
}