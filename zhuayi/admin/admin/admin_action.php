<?php
/*
 * admin_action.php     Zhuayi 后台登录
 *
 * @copyright    (C) 2005 - 2010  zhuayi
 * @licenes      http://www.zhuayi.net
 * @lastmodify   2010-10-28
 * @author       zhuayi
 * @QQ			 2179942
 */
class admin_action extends zhuayi
{

	/* 构造函数 */
	function __construct()
	{
		parent::__construct();
		
		$this->load_class('db');
		$this->load_class('page');
	}

	function index()
	{
		global $config;

		/** 验证是否登录 **/
		$show['admin'] = $this->verify(__METHOD__);
		$show['webname'] = $config['web']['webname'];
		$show['weburl'] = $config['web']['weburl'];

		/* 查询菜单 */
		$show['menu_list'] = db_admin_menu::get_admin_menu_list_by_ids($show['admin']['menu_id'],'0','','','orders asc');
		$this->display($show);
	}

	/** menu_list 菜单列表 **/
	function menu_list()
	{
		/** 验证是否登录 **/
		$this->verify(__METHOD__);

		$show['tips'] = '请在添加、修改、排序菜单全部完成后，更新菜单缓存';

		$show['menu_list'] = db_admin_menu::get_admin_menu_list(array(),'orders asc','all');
		$show['menu_list'] = $this->load_fun('tree',$show['menu_list'],'parent_id');
		//$this->cache->flush('admin_menu');
		$this->display($show);
	}

	/** 编辑菜单 **/
	function menu_edit($id='',$parent_id='')
	{
		/** 验证是否登录 **/
		$this->verify(__METHOD__);

		/* 读取后台菜单数据 */
		$show['list'] = db_admin_menu::get_admin_menu_list(array(),'orders asc','all');
		if (empty($id))
		{
			$show['pagename'] = '菜单添加';
			$parent = db_admin_menu::get_admin_menu_list_by_ids($parent_id);
			$parent = $parent[0];
			$show['parent_id'] = $parent['id'];
			$show['info']['modle'] = $parent['modle'];
			$show['info']['orders'] = 0;
		}
		else
		{
			$show['pagename'] = '菜单编辑';
			$show['info'] = db_admin_menu::get_admin_menu_list_by_ids($id);
			$show['info'] = $show['info'][0];
			$show['parent_id'] = $show['info']['parent_id'];
		}

		$this->display($show);
	}


	/** menu_info 提交菜单 **/
	function menu_info()
	{
		/** 验证是否登录 **/
		$this->verify(__METHOD__);

		if (!empty($_POST['id']))
		{
			db_admin_menu::update_admin_menu_by_id($_POST['id'],$_POST);
		}
		else
		{
			$parent_id = db_admin_menu::insert_admin_menu($_POST);
			if (empty($_POST['parent_id']))
			{
				$_POST['parent_id'] = $parent_id;
				db_admin_menu::insert_admin_menu($_POST);
			}
		}
		
		output::url('/zpadmin/admin/menu_list');
	}

	/** menu_del 删除菜单 **/
	function menu_del($id)
	{
		/** 验证是否登录 **/
		$this->verify(__METHOD__);

		$parent_menu = db_admin_menu::get_admin_menu_list_by_pid($id);

		if (empty($parent_menu[0]))
		{
			db_admin_menu::delete_menu_list_by_id($id);
		}
		else
		{
			throw new Exception("该菜单下还有未删除的菜单,请先删除!", -1);
		}
		output::url('/zpadmin/admin/menu_list');
	}

	/* menu_orders 菜单排序 */
	function menu_orders()
	{
		foreach ($_POST['id'] as $key=>$val)
		{
			db_admin_menu::update_menu_list_orders_by_id($val,$_POST['orders'][$key]);
		}
		output::url('/zpadmin/admin/menu_list');
	}

	/* login 登录 */
	function login()
	{
		$this->display();
	}

	/* login_info */
	function login_info()
	{
		/* 查询帐号 */
		$admin_user = db_admin::get_admin_by_username_password($_POST['username'],$_POST['password']);

		if ($admin_user === false)
		{
			throw new Exception("帐号或密码错误!", -1);
		}

		if ($admin_user['gid'] > 0)
		{
			/* 查询账号组 */
			$admin_group = db_admin_group::get_admin_group_gid($admin_user['gid']);

			/* 删除menu_id 第一位和最后一位 */
			$admin_group['menu_id'] = substr($admin_group['menu_id'],1,(strlen($admin_group['menu_id'])-2));

			/* 查询菜单 */
			if (!empty($admin_group['menu_id']))
			{
				$admin_menu_list = db_admin_menu::get_admin_menu_list_by_ids($admin_group['menu_id']);
			}

			/* 转换菜单数组,取出action和fun */
			$admin_menu_list_temp = array();
			foreach ($admin_menu_list as $key=>$val)
			{
				$admin_menu_list_temp[$val['modle'].'_'.$val['action']] = 1;
			}
			
			/* 设置默认菜单,此方法不需要后台赋予权限 */
			$admin_menu_list_temp['admin_index'] = 1;
			$admin_menu_list_temp['admin_right'] = 1;
			$admin_menu_list_temp['admin_menu'] = 1;

			$admin_menu_list = $admin_menu_list_temp;

			/*　更新登陆时间和登陆ip */
			db_admin::update_admin_login_by_id($admin_user['id']);

			/* 设置COOKIE */
			$admin_user['menu_id'] = $admin_group['menu_id'];
			$admin_user['menu_list'] = $admin_menu_list;
		}

		cookie::set_cookie('admin_user',$admin_user);
		output::url('/zpadmin');

	}

	/* 检查用户是否登陆 */
	function check_login()
	{
		$admin = cookie::ret_cookie('admin_user');
		if (empty($admin['id']))
		{
			output::url('/zpadmin/admin/login');
		}
	}
	
	/*  验证是否登录 */
	function verify($modle='')
	{

		$admin = cookie::ret_cookie('admin_user');

		$select_menu = explode(":",$modle);
		

		if (substr($modle,0,4) == 'json')
		{
			$select_menu = 'api_'.$select_menu[0];
		}
		else
		{
			$select_menu[0] = explode('_',$select_menu[0],2);

			$select_menu[0] = $select_menu[0][0];
			
			$select_menu = $select_menu[0].'_'.$select_menu[2];
		}
		
		if (empty($admin['id']))
		{
			output::url('/zpadmin/admin/login');
		}
		else if (!isset($admin['menu_list'][$select_menu]))
		{
			throw new Exception("您没有此页面管理权限",-1);
		}
		return $admin;

	}

	/** logout 退出登录 **/
	function logout()
	{
		cookie::set_cookie('admin_user','');
		output::url('/zpadmin/admin/login');
	}

	/** right 右侧 **/
	function right()
	{
		/** 验证是否登录 **/
		//$reset = $this->verify(__METHOD__);
		$this->display();
	}

	/* 验证码 */
	function checkcode()
	{

		$this->load_class('checkcode');
		cookie::set_cookie('code',$this->checkcode->get_code(),3600);

		$this->checkcode->doimage();
	}
	
	/* 管理员 */
	function user()
	{

		$this->verify(__METHOD__);

		$username = '';
		if (isset($_GET['username']) && !empty($_GET['username']))
		{
			$username = '{%'.$_GET['username'].'%}';
		}
		$perpage = 20;
		
		if (!isset($_GET['page']))
		{
			$_GET['page'] = 1;
		}

		$limit = ($_GET['page']-1)*$perpage.','.$perpage;

		$show['list'] = db_admin::get_admin_list_by_username($username,' id desc',$limit);

		$show['count'] = db_admin::get_admin_count_by_username($username);

		$show['page'] = $this->page->maxnum($show['count'],$perpage)->show();

		$this->display($show);
	}

	/**
	 * 编辑帐号信息
	 * @param int $id 用户ID
	 * by 2012-03-09
	 */
	function user_edit($id)
	{
		$admin = cookie::ret_cookie('admin_user');

		if ($id != $admin['id'])
		{
			$admin = $this->verify(__METHOD__);
		}
		

		$show['self'] = 1;

		/* 取全部管理组 */
		$show['group_list'] = db_admin_group::get_admin_group_list(' id desc ','all');

		if (empty($id))
		{
			$show['pagename'] = '添加管理员';
		}
		else
		{
			$show['pagename'] = '编辑管理员';
			$show['info'] = db_admin::get_admin_by_id($id);

			if ($show['info']['id'] == $admin['id'])
			{
				$show['self'] = 0;
			}
		}
		$this->display($show);
	}

	/* 删除管理员 */
	function user_del()
	{
		$this->verify(__METHOD__);

		$reset = db_admin::delete_admin_by_ids($_POST['id']);

		throw new Exception("操作成功!", 1);
	}

	/* 帐号组 */
	function group()
	{
		$this->verify(__METHOD__);

		$show['list'] = db_admin_group::get_admin_group_list('id desc','all');

		$this->display($show);
	}

	/* 帐号编辑 */
	function group_edit($id='')
	{
		$this->verify(__METHOD__);

		$show['menu_list'] = db_admin_menu::get_admin_menu_list(array('no_verify'=>0),'id desc','all');

		$show['menu_list'] = $this->load_fun('tree',$show['menu_list'],'parent_id');
		// foreach ($show['menu_list'] as $key=>$val)
		// {
		// 	if ($val['parent_id'] == 0)
		// 	{
		// 		$list[$val['id']] = $val;
		// 	}
		// 	else
		// 	{
		// 		$list2[$val['id']] = $val;
		// 	}
		// }

		// foreach ($list2 as $key=>$val)
		// {
		// 	if (!empty($list2[$val['parent_id']]))
		// 	{
		// 		$list2[$val['parent_id']]['menu_list'][] = $val;
		// 	}
			
		// }
		// foreach ($list2 as $key=>$val)
		// {
		// 	if (!empty($list[$val['parent_id']]))
		// 	{
		// 		$list[$val['parent_id']]['menu_list'][] = $list2[$key];
		// 	}
		// }
		// unset($list2);
		// $show['menu_list'] = $list;
		// unset($list);
		// print_r($show['menu_list']);
		// exit;
		if (!empty($id))
		{
			$show['info'] = db_admin_group::get_admin_group_by_id($id);
			$show['info']['menu_id'] = explode(',',$show['info']['menu_id']);
			$show['info']['menu_id'] = array_unique($show['info']['menu_id']);
			$show['info']['menu_id'] = array_flip($show['info']['menu_id']);
			$show['pagename'] = '编辑账号组';
		}
		else
		{
			$show['pagename'] = '添加账号组';
		}
		

		$this->display($show);
	}

	/* 帐号组入库 */
	function group_info()
	{

		$this->verify(__METHOD__);

		$_POST['menu_id'] = implode(',',$_POST['menu_id']);

		if (!empty($_POST['menu_id']))
		{
			$_POST['menu_id'] = ','.$_POST['menu_id'].',';
		}
		
		if (empty($_POST['id']))
		{
			/* 插入 */
			db_admin_group::insert_admin_group($_POST['group_name'],$_POST['menu_id']);
		}
		else
		{
			/* 更新 */
			db_admin_group::update_admin_group_by_id($_POST['id'],$_POST['group_name'],$_POST['menu_id']);
		}
		output::url('/zpadmin/admin/group');
	}

	/* 删除帐号组 */
	function group_del($id)
	{
		$this->verify(__METHOD__);

		db_admin_group::delete_admin_group_by_id($id);

		output::url('/zpadmin/admin/group');
	}

	/* 页面统计 */
	function stauts_time()
	{
		$this->verify(__METHOD__);
		
		if (!isset($_GET['starttime']))
		{
			$_GET['starttime'] = date("Y-m-d").' 00:00:00';
		}

		if (!isset($_GET['endtime']))
		{
			$_GET['endtime'] = date("Y-m-d").' 23:59:59';
		}

		$perpage = 20;
		$limit = ($_GET['page']-1)*$perpage.','.$perpage;

		$show['list'] = db_admin::get_stauts_time_list_by_time($_GET['starttime'],$_GET['endtime'],' page_time desc',$limit);
		$show['maxnum'] = db_admin::get_stauts_time_maxnum_by_time($_GET['starttime'],$_GET['endtime']);
		
		$show['page'] = $this->page->maxnum($show['maxnum'],$perpage)->show();

		$this->display($show);
	}
}