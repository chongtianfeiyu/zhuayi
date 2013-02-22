<?php
/*
 * mod_app.php     Zhuayi 应用统一模型
 *
 * @copyright    (C) 2005 - 2010  zhuayi
 * @licenes      http://www.zhuayi.net
 * @lastmodify   2010-10-28
 * @author       zhuayi
 * @QQ			 2179942
 */

class mod_app extends zhuayi
{

	/* 构造函数 */
	function __construct()
	{

	}

	/* 获取登录用户信息 */
	function get_user_info()
	{
		return cookie::ret_cookie('user_info');
	}

	function get_weburl()
	{
		global $config;
		return $config['web']['weburl'];
	}

	

	/* 取配置数组 */
	function get_app_config_data_by_key($key,$val)
	{
		global $config;
		return $config['app_config'][$key][$val];
	}


	/* 取OS平台 */
	function get_app_config_data_list($key)
	{
		global $config;
		return $config['app_config'][$key];
	}

	
}
?>