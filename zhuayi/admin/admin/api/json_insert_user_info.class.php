<?php
/*
 * json_insert_user_info.php     Zhuayi 会员入库
 *
 * @copyright    (C) 2005 - 2010  zhuayi
 * @licenes      http://www.zhuayi.net
 * @lastmodify   2010-10-28
 * @author       zhuayi
 * @QQ			 2179942
 */
class json_insert_user_info extends zhuayi
{

	function __construct()
	{
		parent::__construct();
		$this->load_class('db');
	}

	function run($id)
	{
		$admin = cookie::ret_cookie('admin_user');

		if ($_POST['id'] != $admin['id'])
		{
			$admin = admin_action::verify(__METHOD__);
		}

		/* 如果$POST['id']为空,则为新增用户 */
		if (empty($_POST['id']))
		{
			$admin_user = db_admin::get_admin_list_by_username($_POST['username']);

			if (!empty($admin_user[0]['id']))
			{
				throw new Exception("帐号重复,不允许添加!", "-1");
			}
			/* 写入账号 */
			$reset = db_admin::insert_admin($_POST['username'],$_POST['password'],$_POST['gid']);

		}
		else
		{
			/* 更新账号 */
			$reset = db_admin::update_admin_by_id($_POST['id'],$_POST['username'],$_POST['password'],$_POST['gid']);
		}
		throw new Exception("操作成功!", 1);
	}

}