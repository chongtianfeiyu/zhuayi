<?php
/**
 * memcache缓存类
 *
 * @package default
 * @author zhuayi
 **/
class mem_cache
{
	
	var $debug;

	/* MC执行次数 */
	var $cache_maxnum = 0;

	/* 命中次数 */
	var $cache_hitnum = 0;

	var $flag = false;

	/**
	 * 构 造 函 数
	 *
	 * @author zhuayi
	 */
	function __construct($fields = array())
	{
		if (isset($_GET['cache_debug']))
		{
			/* 是否开启debug */
			$this->debug = true;
		}

		/* 兼容SAE memcache */
		if (!function_exists('memcache_init'))
		{
			$this->mc = new Memcache;
			$reset = @$this->mc->pconnect(SAE_MEMCACHED_HOST, SAE_MEMCACHED_PORT);
			if ($reset === false)
			{
				throw new Exception("Memcache 没有开启!", -1);
			}

		}
		else
		{
			$this->mc = memcache_init();
		}
	}

	/* 设置缓存组 */
	function group($group)
	{
		return $this->mc->get('group_'.$group); 
	}

	/**
	 * set 设 置 缓 存
	 *
	 * @author zhuayi
	 */
	function set($key,$value,$expire='',$flag='',$group='')
	{
		if (is_array($value))
		{
			$value = json_encode($value);
		}

		if ($expire === '')
		{
			$expire = SAE_MEMCACHED_OUTTIME;
		}
		if ($flag === '')
		{
			$flag = $this->flag;
		}

		if (!empty($group))
		{
			$key = $this->group($group).'_'.$key;
		}
		
		if ($this->debug)
		{
			echo "<!--\n cache: set({$key}, ".print_r($value,true).", {$flag}, {$expire}) \n-->\n";
		}
		return $this->mc->set(md5(SAE_MEMCACHED_KEY.$key),$value,$flag,$expire);
	}
	
	/**
	 * increment 进行加法
	 *
	 * @param string $key 
	 * @param string $value 
	 * @return void
	 * @author zhuayi
	 */
	function increment($key,$value,$group='')
	{
		if (!empty($group))
		{
			$key = $this->group($group).'_'.$key;
		}

		if ($this->debug)
		{
			echo "<!-- cache::set({$key}, {$value}, {$flag}, {$expire}) -->\n";
		}

		return $this->mc->increment(md5(SAE_MEMCACHED_KEY.$key),$value);
	}
	
	/**
	 * decremen 进行减法
	 *
	 * @param string $key 
	 * @param string $value 
	 * @return void
	 * @author zhuayi
	 */
	function decremen($key,$value,$group='')
	{
		if (!empty($group))
		{
			$key = $this->group($group).'_'.$key;
		}

		if ($this->debug)
		{
			echo "<!-- cache_set: ({$key}, ".print_r($value,true).", {$flag}, {$expire}) -->\n";
		}
		return $this->mc->decremen(md5(SAE_MEMCACHED_KEY.$key),$value);
	}
	
	/**
	 * get 获 取 缓 存
	 *
	 * @author zhuayi
	 */
	function get($key,$type = false,$group='')
	{
		if (!empty($group))
		{
			$key = $this->group($group).'_'.$key;
		}
		
		$this->cache_maxnum++;

		/* 重置缓存 */
		if (isset($_GET['recache']))
		{
			return false;
		}

		$debug_key = $key;

		if (is_array($key))
		{
			foreach ($key as $val)
			{
				$key_list[] = md5(SAE_MEMCACHED_KEY.$val);
			}
			$key = $key_list;
		}
		else
		{
			$key = md5(SAE_MEMCACHED_KEY.$key);
		}

		$reset = $this->mc->get($key);
		
		if ($this->debug)
		{
			echo "<!--\n cache_get: ".print_r($debug_key,true)." ";
			var_dump(print_r($reset,true));
			echo " \n-->\n";
		}
		
		$this->cache_hitnum++;

		if ($type === true)
		{
			return $reset;
		}

		$json = json_decode($reset,true);

		if (is_array($json))
		{
			$reset =  $json;
		}

		return $reset;
		
	}
	
	/**
	 * delete 删 除 缓 存 
	 *
	 * @author zhuayi
	 */
	function delete($key,$group='')
	{
		if (!empty($group))
		{
			$key = $this->group($group).'_'.$key;
		}

		if ($this->debug)
		{
			echo "<!--\n cache: delete({$key}) \n-->\n";
		}

		return $this->mc->delete(md5(SAE_MEMCACHED_KEY.$key));
	}

	/**
	 * 批量删除缓存组 
	 *
	 * @author zhuayi
	 */
	function flush($group)
	{
		$reset = $this->group($group);
		$reset++;
        $reset = $this->mc->set('group_'.$group, $reset);
	}

	/* 插入一个数组进入目标缓存 */
	function append_array($cache_key,$value = array())
	{
		$reset = $this->get($cache_key);

		/* 检查是否已存在配置 */
		if (isset($reset[key($value)]))
		{
			return true;
		}
		if (!is_array($value))
		{
			throw new Exception("目标缓存不是一个数组,插入失败", -1);
		}

		$reset = array_merge($reset,$value);

		return $this->set($cache_key,$reset);
	}
}

?>
