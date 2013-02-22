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

	static $db_list = array();

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

		$mongo_link_url = "mongodb://{$this->username}:{$this->password}@{$this->host}:{$this->port}";

		try
		{
			parent::__construct($mongo_link_url,array("persist" => "x"));

		}
		catch (Exception $e)
		{
			print_r($e);
			throw new Exception("mongodb连接失败", -1);
			
		}
		
		$this->collection = $this->$this->db;
		// /* 加载缓存类 */
		// $this->cache = & $cache;

		// /* 定义表前缀 */
		// define('T', $this->mysql_pre);

	}

	function select_db($db_name)
	{
		$this->$db_name;
		//$this->db_list[$db_name] = $this->$db_name;
	}


}