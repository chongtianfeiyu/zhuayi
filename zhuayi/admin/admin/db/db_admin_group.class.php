<?php
/*
 * db_admin_group.php     Zhuayi 管理员数据模型
 *
 * @copyright    (C) 2005 - 2010  zhuayi
 * @licenes      http://www.zhuayi.net
 * @lastmodify   2010-10-28
 * @author       zhuayi
 * @QQ			 2179942
 */

 
class db_admin_group extends zhuayi
{
	/**
	 * 根据ID查询账号组
	 * @param int $gid 账号
	 */
	function get_admin_group_gid($gid)
	{
		$array['id'] = $gid;
		$array['status'] = 1;
		return $this->db->select_db('default')->fetch('admin_group',$array);
	}

	/**
	 * 查询账号组
	 * @param int $gid 账号
	 */
	function get_admin_group_list($order='',$limit='')
	{
		$array['status'] = 1;

		return $this->db->select_db('default')->fetch_row('admin_group',$array,$order,$limit);
	}

	/**
	 * 根据ID查询账号组
	 * @param int $gid 账号
	 */
	function get_admin_group_by_id($id)
	{
		$array['id'] = $id;
		$array['status'] = 1;
		return $this->db->select_db('default')->fetch('admin_group',$array);
	}

	/**
	 * 更新账号组
	 * @param int $gid 账号
	 */
	function update_admin_group_by_id($id,$group_name,$menu_id)
	{
		$array['group_name'] = $group_name;
		$array['menu_id'] = $menu_id;
		return $this->db->select_db('default')->update('admin_group',$array," id = {$id}");
	}

	/**
	 * 写入账号组
	 * @param int $gid 账号
	 */
	function insert_admin_group($group_name,$menu_id)
	{
		$array['group_name'] = $group_name;
		$array['menu_id'] = $menu_id;
		$array['status'] = 1;
		return $this->db->select_db('default')->insert('admin_group',$array);
	}

	/**
	 * 删除账号组
	 * @param int $gid 账号
	 */
	function delete_admin_group_by_id($id)
	{
		return $this->db->select_db('default')->update('admin_group',array('status'=>'0')," id = {$id}");
	}
}
?>