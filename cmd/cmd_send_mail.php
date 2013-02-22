<?php
/*
 * cmd.php     Zhuayi cron
 *
 * @copyright    (C) 2005 - 2010  zhuayi
 * @licenes      http://www.zhuayi.net
 * @lastmodify   2010-10-28
 * @author       zhuayi
 * @QQ			 2179942
 */
include_once "../cron/cron.inc.php";

class cmd extends zhuayi
{

	/* 构造函数 */
	function __construct()
	{
		parent::__construct();
		
		$this->load_class('email',true);

	}

	function run($argv)
	{
		list($filename,$mail,$title,$body,$file) = $argv;

		if (empty($mail) || empty($title))
		{
			throw new Exception("参数错误!", 1);
		}

		if (!empty($file))
		{
			$this->email->file($file);
		}
		$reset = $this->email->send($mail,$title,$body);
		var_dump($reset);
		
	}
}

$cron = new cmd();
try
{
	
	$reset = false;
	do
	{
		$reset = $cron->run($argv);
	}
	while ($reset===false);
	
} 
catch (ZException $e){}

?>