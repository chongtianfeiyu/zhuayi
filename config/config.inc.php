<?php
/**
* config.inc.php     Zhuayi 入口文件
*
* @copyright    (C) 2005 - 2010  Zhuayi
* @licenes      http://www.zhuayi.net
* @lastmodify   2010-10-27
* @author       zhuayi
* @QQ			2179942
*/
/* error debug */
defined('ZHUAYI_ROOT') or define('ZHUAYI_ROOT', str_replace("\\", '/', substr(dirname(__FILE__),0,-6)));

/*  输出页面字符集 */
header('Content-type: text/html; charset=utf-8');

/* -----设置时区  */
date_default_timezone_set('Asia/Shanghai');

/* -----定义Zhuayi根目录路径  */
define('APP_ROOT', ZHUAYI_ROOT.'/zhuayi/');

define('PLUGINS_ROOT', ZHUAYI_ROOT.'/plugins/');

require ZHUAYI_ROOT.'/config/config.php';

/* DB 变量 */
defined('SAE_MYSQL_HOST_M') or define('SAE_MYSQL_HOST_M', $_SERVER['SAE_MYSQL_HOST_M']);
defined('SAE_MYSQL_HOST_S') or define('SAE_MYSQL_HOST_S', $_SERVER['SAE_MYSQL_HOST_S']);
defined('SAE_MYSQL_USER') or define('SAE_MYSQL_USER', $_SERVER['SAE_MYSQL_USER']);
defined('SAE_MYSQL_PASS') or define('SAE_MYSQL_PASS', $_SERVER['SAE_MYSQL_PASS']);
defined('SAE_MYSQL_DB') or define('SAE_MYSQL_DB', $_SERVER['SAE_MYSQL_DB']);
defined('SAE_MYSQL_PORT') or define('SAE_MYSQL_PORT', $_SERVER['SAE_MYSQL_PORT']);

/* Memcached */
defined('SAE_MEMCACHED_HOST') or define('SAE_MEMCACHED_HOST', $_SERVER['SAE_MEMCACHED_HOST']);
defined('SAE_MEMCACHED_PORT') or define('SAE_MEMCACHED_PORT', $_SERVER['SAE_MEMCACHED_PORT']);
defined('SAE_MEMCACHED_OUTTIME') or define('SAE_MEMCACHED_OUTTIME', $config['cache']['outtime']);
defined('SAE_MEMCACHED_LIST_OUTTIME') or define('SAE_MEMCACHED_LIST_OUTTIME', $config['cache']['list_outtime']);
defined('SAE_MEMCACHED_KEY') or define('SAE_MEMCACHED_KEY', $_SERVER['SAE_MEMCACHED_KEY']);

/* 文件主目录 */
defined('SAE_FILE_PATH') or define('SAE_FILE_PATH', $_SERVER['SAE_FILE_PATH']);

/* 判断是否SAE项目 */
/**
 * ----------------------------------------------------
 * sae app 
 * ----------------------------------------------------
 */

if (isset($_SERVER['HTTP_APPNAME']))
{
	$config['sae_config']['app_name'] = $_SERVER['HTTP_APPNAME'];

	$config['sae_config']['storage'] = "data";

	if ($_SERVER['HTTP_APPVERSION'] > 1)
	{
		$config['sae_config']['app_url'] = "http://{$_SERVER['HTTP_APPVERSION']}.{$_SERVER['HTTP_APPNAME']}.sinaapp.com";
	}
	else
	{
		$config['sae_config']['app_url'] = "http://{$_SERVER['HTTP_APPNAME']}.sinaapp.com";
	}
	
	$config['sae_config']['taskqueue'] = 'app';

	$config['file']['path']['litpic']['url'] = str_replace($config['web']['weburl'],'',$config['file']['path']['litpic']['url']);
	$config['file']['path']['litpic']['url'] = "http://{$_SERVER['HTTP_APPNAME']}-{$config['sae_config']['storage']}.stor.sinaapp.com".$config['file']['path']['litpic']['url'];
	$config['file']['path']['litpic']['root'] = "saestor://{$config['sae_config']['storage']}".str_replace(ZHUAYI_ROOT,'',$config['file']['path']['litpic']['root']);

	/* 缓存目录 */
	define('SINASRV_CACHE_DIR', "saemc://{$_SERVER['HTTP_APPNAME']}");
}
else
{
	/* 判断是否目录,如果是目录,则是本地,否则为远程S3 */
	$file_config = explode('::',SAE_FILE_PATH);
	if (!isset($file_config[1]))
	{
		/* 文件写入存放地址 */
		for($i=1;$i<=10;$i++)
		{
			$config['file']['path'][$i]['url'] = "/data/{$config['web']['appname']}/";
			$config['file']['path'][$i]['root'] = SAE_FILE_PATH."{$config['web']['appname']}/";
		}
		
	}
	else
	{
		//oss::zhuayi, 规则,服务::domain
		
		$config['file']['path'][0]['url'] = $file_config['1'].$file_config['2'];
		$config['file']['path'][0]['root'] = $file_config['2'];
		$config['file']['server'] = $file_config[0];
	}
	
	

	/* 缓存目录 */
	defined('SINASRV_CACHE_DIR') or define('SINASRV_CACHE_DIR', $_SERVER['SINASRV_CACHE_DIR']);
}

if (!isset($_SERVER['HTTP_HOST']))
{
	$_SERVER['HTTP_HOST'] = ZHUAYI_ROOT;
}

require ZHUAYI_ROOT.'/plugins/core/zhuayi.php';

?>
