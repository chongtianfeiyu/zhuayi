<?php
/*
 * db_admin.php     Zhuayi 管理员数据模型
 *
 * @copyright    (C) 2005 - 2010  zhuayi
 * @licenes      http://www.zhuayi.net
 * @lastmodify   2010-10-28
 * @author       zhuayi
 * @QQ			 2179942
 */

 
class db_admin extends zhuayi
{
	static $table_name = "admin";
	
	/**
	 * 根据账号密码查询帐号
	 * @param string $username 账号
	 * @param string $password 密码
	 */
	function get_admin_by_username_password($username,$password)
	{
		$array['username'] = $username;
		$array['password'] = strings::mymd5($password);
		$array['status']   = 0;
		return $this->db->select_db('default')->fetch(self::$table_name,$array);
	}

	/**
	 * 更新账号登陆时间和登陆IP
	 * @param string $id 
	 */
	function update_admin_login_by_id($id)
	{
		$array['logintime'] = date("Y-m-d H:i:s");
		$array['login_ip']  = ip::get_ip();
		return $this->db->select_db('default')->update(self::$table_name,$array,"id = {$id}");
	}

	/**
	 * 根据用户名模糊搜索用户
	 * @param string $username 
	 */
	function get_admin_list_by_username($username,$order='',$limit='')
	{
		if (!empty($username))
		{
			$array['username'] = "{$username}";
		}
		$array['status'] = 0;
		return $this->db->select_db('default')->fetch_row(self::$table_name,$array,$order,$limit);
	}

	/**
	 * 根据用户名模糊搜索总数
	 * @param string $id 
	 */
	function get_admin_count_by_username($username)
	{
		if (!empty($username))
		{
			$array['username'] = "{$username}";
		}
		$array['status'] = 0;
		return $this->db->select_db('default')->count(self::$table_name,$array);
	}


	/**
	 * 根据ID,查询用户
	 * @param string $id 
	 */
	function get_admin_by_id($id)
	{
		$array['id']     = $id;
		$array['status'] = 0;
		return $this->db->select_db('default')->fetch(self::$table_name,$array);
	}

	/**
	 * 根据ID,查询用户
	 * @param string $id 
	 */
	function get_admin_by_ids($ids)
	{
		if (!is_array($ids))
		{
			throw new Exception("参数错误!", -1);
		}

		foreach ($ids as $key=>$val)
		{
			$ids[$key] = intval($val);
		}

		$ids = implode(',',$ids);

		if (empty($ids))
		{
			throw new Exception("参数错误!", -1);
		}

		$array['id']     = " {in}({$ids}) ";
		$array['status'] = 0;
		return $this->db->select_db('default')->fetch_row(self::$table_name,$array,'','all');
	}

	/**
	 * 写入用户
	 * @param string $id 
	 */
	function insert_admin($username,$password,$gid)
	{
		$array['username'] = $username;
		$array['password'] = strings::mymd5($password);
		$array['gid']      = $gid;
		$array['status']   = 0;
		return $this->db->select_db('default')->insert(self::$table_name,$array);
	}

	/**
	 * 更新用户
	 * @param string $id 
	 */
	function update_admin_by_id($id,$username,$password,$gid)
	{
		$array['username'] = $username;

		if (!empty($password))
		{
			$array['password'] = strings::mymd5($password);
		}
		if (!empty($gid))
		{
			$array['gid'] = $gid;
		}
		return $this->db->select_db('default')->update(self::$table_name,$array," id = {$id}");
	}

	/**
	 * 批量删除用户
	 * @param string $id 
	 */
	function delete_admin_by_ids($id)
	{
		if (is_array($id))
		{
			$id = implode(',',$id);
			$where = "id in ({$id})";
		}
		else
		{
			$where = " id = {$id}";
		}
		$array['status'] = 1;
		return $this->db->select_db('default')->update(self::$table_name,$array,$where);
	}
}
?>