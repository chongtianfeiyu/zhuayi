<?php
/*
 * mod_admin.php     Zhuayi 管理员数据模型
 *
 * @copyright    (C) 2005 - 2010  zhuayi
 * @licenes      http://www.zhuayi.net
 * @lastmodify   2010-10-28
 * @author       zhuayi
 * @QQ			 2179942
 */

class mod_admin extends zhuayi
{

	/* 构造函数 */
	function __construct()
	{

	}

	function header($show)
	{
		$show['menu'] = mod_admin::get_admin_header_menu();
		require $this->load_tpl('admin_header');
	}
	
	/* 取后台头部同类菜单 */
	function get_admin_header_menu()
	{
		$menu_id = db_admin_menu::get_admin_menu_list_by_modle_action($this->modle,$this->action,'orders asc','all');
		$menu_id = array(0=>$menu_id[0]);

		$small_menu = db_admin_menu::get_admin_menu_list_by_pid($menu_id[0]['id'],'0','orders asc');

		if (empty($small_menu))
		{
			$small_menu = array();
		}
		if ($menu_id[0]['top'] == 0)
		{
			$menu_id = array_merge(array('0'=>$menu_id[0]),$small_menu);
		}
		else
		{
			unset($menu_id);
		}
		return  $menu_id;
	}

	/* 取当前登录用户ID */
	function get_admin_uid()
	{
		$admin = cookie::ret_cookie('admin_user');
		return $admin['id'];
	}
	
	/* 取当前登录用户ID */
	function get_admin_username()
	{
		$admin = cookie::ret_cookie('admin_user');
		return $admin['username'];
	}

	/* 传递一个带有uid的数组,返回带有用户名的数组 */
	function get_admin_by_array($array,$uid_key='')
	{
		/* 取UIDS */
		foreach ($array as $val)
		{
			$uids[] = $val[$uid_key];
		}

		if (empty($uids))
		{
			return $array;
		}
		$admin_list = db_admin::get_admin_by_ids($uids);
		foreach ($admin_list as $val)
		{
			$admin_list_tmp[$val['id']] = $val;
		}

		foreach ($array as $key=>$val)
		{
			$array[$key]['admin'] = $admin_list_tmp[$val[$uid_key]];
		}

		return $array;
	}
}
?>