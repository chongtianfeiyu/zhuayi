<?php
/**
 * memcacheq 队列服务器
 *
 * @package default
 * @author zhuayi
 **/
class memcacheq
{
	/* 队列服务器端口,如果为memcacheq,则需要设置端口 */
	public $port;

	public $server;

	/**
	 * 构 造 函 数
	 *
	 * @author zhuayi
	 */
	function __construct($fields = array())
	{
		foreach ($fields as $key=>$val)
		{
			$this->$key = $val;
		}
		/* 兼容SAE memcache */
		if (!function_exists('memcache_init'))
		{
			$this->mcq = new Memcache;
			$reset = @$this->mcq->pconnect($this->server, $this->port);
			if ($reset === false)
			{
				throw new Exception("Memcacheq 没有开启!", -1);
			}

		}
		else
		{
			throw new Exception("memcacheq不被支持!", -1);
		}
	}


	/* 添加任务 */
	function addTask($url)
	{
		if (!is_array($url))
		{
			throw new Exception("参数错误!", -1);
		}
		$i = $j = 1;
		foreach ($url as $val)
		{
			$url_tmp[$j][] = $val['url'];

			if ($i % 3 == 0)
			{
				$j++;
			}
			$i++;
		}
		foreach ($url_tmp as $val)
		{
			$val = json_encode($val);
			$this->mcq->set($this->task_name,$val);
		}
		return true;
	}


	/* 兼容SAE */
	function push()
	{
		return true;
	}


	/* 取任务 */

	function get($task_name)
	{
		return $this->mcq->get($task_name);
	}

	
}

?>
