<?php
/*
 * db_admin_menu.php     Zhuayi 管理员数据模型
 *
 * @copyright    (C) 2005 - 2010  zhuayi
 * @licenes      http://www.zhuayi.net
 * @lastmodify   2010-10-28
 * @author       zhuayi
 * @QQ			 2179942
 */

 
class db_admin_menu extends zhuayi
{
	/**
	 * 查找菜单
	 * @param string $id 
	 */
	function get_admin_menu_list($order,$limit)
	{
		return $this->db->select_db('default')->fetch_row('admin_menu ',array('status'=>0),$order,$limit);
	}

	/**
	 * 根据modle,action查找菜单
	 * @param string $id 
	 */
	function get_admin_menu_list_by_modle_action($modle,$action,$order,$limit)
	{
		$array['modle'] = $modle;
		if (!empty($action))
		{
			$array['action'] = $action;
		}
		$array['status'] = 0;
		return $this->db->select_db('default')->fetch_row('admin_menu ',$array,$order,$limit);
	}

	/**
	 * 根据ID批量查找菜单
	 * @param string $id 
	 */
	function get_admin_menu_list_by_ids($ids,$parent_id = '',$top='',$hidden='',$order='')
	{
		if (empty($ids))
		{
			return array();
		}

		$array['id'] = "{in}({$ids})";
		
		if ($parent_id !== '')
		{
			$array['parent_id'] = $parent_id;
		}
		if ($top !='')
		{
			$array['top'] = $top;
		}
		if ($hidden !='')
		{
			$array['hidden'] = $hidden;
		}
		$array['status'] = 0;

		return $this->db->select_db('default')->fetch_row('admin_menu',$array,$order,'all');
	}

	/**
	 * 根据pid查找菜单
	 * @param string $id 
	 */
	function get_admin_menu_list_by_pid($pid,$top,$order = '',$limit = 'all')
	{
		$array['parent_id'] = $pid;
		if ($top !='')
		{
			$array['top'] = $top;
		}
		$array['status'] = 0;

		return $this->db->select_db('default')->fetch_row('admin_menu',$array,$order,$limit);
	}

	/**
	 * 删除菜单
	 * @param string $id 
	 */
	function delete_menu_list_by_id($id)
	{
		return $this->db->select_db('default')->update('admin_menu',array('status'=>'1'),"id = {$id}");
	}

	/**
	 * 更新菜单
	 * @param string $id 
	 */
	function update_admin_menu_by_id($id,$par)
	{
		$array['title'] = $par['title'];
		$array['modle'] = $par['modle'];
		$array['action'] = $par['action'];
		$array['url'] = $par['url'];
		$array['parent_id'] = $par['parent_id'];
		$array['orders'] = $par['orders'];
		$array['hidden'] = $par['hidden'];
		$array['target'] = $par['target'];
		$array['top'] = $par['top'];
		$array['ajax'] = $par['ajax'];
		
		$this->db->select_db('default')->update('admin_menu',$array," id = {$id}");
		return true;
	}

	/**
	 * 插入菜单
	 * @param string $id 
	 */
	function insert_admin_menu($par)
	{
		$array['title'] = $par['title'];
		$array['modle'] = $par['modle'];
		$array['action'] = $par['action'];
		$array['url'] = $par['url'];
		$array['parent_id'] = $par['parent_id'];
		$array['orders'] = $par['orders'];
		$array['hidden'] = $par['hidden'];
		$array['target'] = $par['target'];
		$array['top'] = $par['top'];
		$array['ajax'] = $par['ajax'];
		$array['status'] = 0;
		return $this->db->select_db('default')->insert('admin_menu',$array);
	}

	/**
	 * 更新菜单排序
	 * @param string $id 
	 */
	function update_menu_list_orders_by_id($id,$orders)
	{
		$array['orders'] = $orders;
		return $this->db->select_db('default')->update('admin_menu',$array," id = {$id}");
	}


}
?>