<?php
/**
 * mongo_db.class.php     Zhuayi mongo_db
 *
 * @copyright    (C) 2005 - 2010  Zhuayi
 * @licenes      http://www.zhuayi.net
 * @lastmodify   2010-10-27
 * @author       zhuayi
 * @QQ			 2179942
 * 
 */
class dbmongo extends Mongo
{
	private $database;

	/**
	 * 构造函数
	 * @param find $fields 数据库配置文件 
	 */
	function __construct($fields = array())
	{

		global $cache;

		extract($fields, EXTR_OVERWRITE);
		
		foreach ($fields as $key=>$val)
		{
			$this->$key = $val;
		}
		if (!empty($this->username) && !empty($this->password))
		{
			$mongo_link_url = "mongodb://{$this->username}:{$this->password}@{$this->host}:{$this->port}";
		}
		else
		{
			$mongo_link_url = "mongodb://{$this->host}:{$this->port}";
		}
		try
		{
			parent::__construct($mongo_link_url,array("persist" => "x"));

		}
		catch (Exception $e)
		{
			print_r($e);
			throw new Exception("mongodb连接失败", -1);
		}
	}

	function select_db($db_name)
	{
		$this->db = $this->$db_name;
		return $this;
	}

	/* */
	function get_collection($tablename)
	{
		return $this->db->$tablename;
	}

	function fetch_row($tablename)
	{
		return $this->get_collection($tablename)->find();
	}

	function insert($tablename,$insert_array)
	{
		if (!is_array($insert_array))
		{
			throw new Exception("插入数据结构出错!", -1);
		}

		return $this->get_collection($tablename)->insert($insert_array);
	}






}