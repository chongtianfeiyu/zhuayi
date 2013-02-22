<?php
/*
 * 队列进程  
 * nohup /usr/local/php/bin/php cmd_memcacheq.php 2>&1 > /dev/null &
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
		
		$this->load_class('oss');

	}

	function run()
	{
		$dir = '/Users/zhuayi/site/img.zhuayi.net';
		$reset = $this->oss->upload_by_dir($dir,true);
		print_r($reset);
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