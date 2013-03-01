<?php
/*
 * json_get_menu_list.php     Zhuayi 取菜单
 *
 * @copyright    (C) 2005 - 2010  zhuayi
 * @licenes      http://www.zhuayi.net
 * @lastmodify   2010-10-28
 * @author       zhuayi
 * @QQ			 2179942
 */
class json_get_menu_list extends zhuayi
{

	function __construct()
	{
		parent::__construct();
		$this->load_class('db');
	}

	function run($id)
	{
		$admin = cookie::ret_cookie('admin_user');
		
		$id = intval($id);

		$show = db_admin_menu::get_admin_menu_list_by_ids($admin['menu_id'],$id,'','','orders asc');

		foreach ($show as $key=>$val)
		{
			$show[$key]['menu_list'] = db_admin_menu::get_admin_menu_list_by_ids($admin['menu_id'],$val['id'],'','0','orders asc',$val['parent_no_verify']);
		}
		$show = json_encode($show);
		throw new Exception($show, "1");
	}

}