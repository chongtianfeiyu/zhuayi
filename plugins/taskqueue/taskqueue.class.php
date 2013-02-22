<?php
/*
 * taskqueue.php     Zhuayi 队列
 *
 * @copyright    (C) 2005 - 2010  zhuayi
 * @licenes      http://www.zhuayi.net
 * @lastmodify   2010-10-28
 * @author       zhuayi
 * @QQ			 2179942
 */

class taskqueue
{

	/* taskqueue队列名 */
	public $task_name;
	
	/* 队列类型,本地需要memcacheq支持,或者SAE的taskqueue */
	public $task_type;

	/**
	 * 构 造 函 数
	 *
	 * @author zhuayi
	 */
	function __construct($array)
	{
		foreach ($array as $key=>$val)
		{
			$this->$key = $val;
		}

		if ($this->task_type == 'sae')
		{
			$this->task = new SaeTaskQueue($this->task_name);
		}
		else if ($this->task_type == 'memcacheq')
		{
			$memcacheq_config = require PLUGINS_ROOT.'memcacheq/config/memcacheq.config.php';
			$this->task = new memcacheq($memcacheq_config);
		}
		else
		{
			throw new Exception("不支持的类型", -1);
		}
	}

	/* 队列执行 */
	function run($url)
	{
		$this->task->task_name = $this->task_name;
		$url = $this->reset_url($url);
		$this->task->addTask($url);
		return $this->task->push();
	}

	/* 本地执行,非队列 */
	function local_run($url,$delay=0)
	{
		shuffle($url);

		$url = $this->reset_url($url);

		$reset = array();
		foreach ($url as $val)
		{
			$reset[$val['url']] = file_get_contents($val['url']);
			sleep($delay);
		}
		return $reset;
	}

	/* 重组URL */
	function reset_url($url)
	{
		global $config;

		if (isset($_SERVER['HTTP_APPNAME']))
		{
			$app_url = $config['sae_config']['app_url'];
		}
		else
		{
			$app_url = $config['web']['weburl'];
		}
		if (is_array($url))
		{
			$array = array();
			foreach ($url as $val)
			{
				if (substr($val,0,'4') !== 'http')
				{
					$val = $app_url.$val;
				}
				$array[] = array('url'=>$val);
			}
			shuffle($array);
		}
		else
		{
			if (substr($url,0,'4') !== 'http')
			{
				$url = $app_url.$url;
			}

			$array[] = array('url'=>$url);
		}
		return $array;
	}
}
 
?>