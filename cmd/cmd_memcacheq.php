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
		
		$this->load_class('memcacheq',true);

	}

	function run()
	{
		$save_path = dirname(__FILE__).'/log/'.date("Y-m-d").'/';

		$this->file->mkdir_file($save_path);

		$reset = $this->memcacheq->get('xiamo');
		
		$urls = json_decode($reset,true);
		var_dump($urls);
		$mh = curl_multi_init();
        $ch = array();
        $chunck = 10; //并发控制数
        $all = count($urls);//所有的请求url数组
        $chunck = $all > $chunck ? $chunck : $all;
		
		$options = array(
			CURLOPT_HEADER=>FALSE,
			CURLOPT_RETURNTRANSFER=>TRUE,
			CURLOPT_FOLLOWLOCATION=>TRUE,
			CURLOPT_MAXREDIRS=>5,
			CURLOPT_USERAGENT=>'Mozilla/5.0 (Windows NT 6.1; rv:6.0) Gecko/20100101 Firefox/6.0'
		);
		
		for($i = 0 ; $i < $chunck ; $i++){
			$ch[$i] = curl_init();
			curl_setopt($ch[$i],CURLOPT_URL,$urls[$i]);
			curl_setopt_array($ch[$i],$options);
			curl_multi_add_handle($mh,$ch[$i]);
		}
		
		do {
	        while(($execrun = curl_multi_exec($mh, $running)) == CURLM_CALL_MULTI_PERFORM);
	        if($execrun != CURLM_OK)break;
	        // a request was just completed -- find out which one
	        while($done = curl_multi_info_read($mh)) {
                //获取已经返回的url在urls数组里德的index
	            $index = array_search($done['handle'],$ch);
	            
	            $info = curl_getinfo($done['handle']);
	            if ($info['http_code'] == 200){
	                $output = curl_multi_getcontent($ch[$index]);
	                // request successful.  process output using the callback function.
	                $save_path .= urlencode($info['url']).'.txt';//数据保存路径
					file_put_contents($save_path,$output);
	
	                // start a new request (it's important to do this before removing the old one)
	                $next = $i++;// increment i
	                $ch[$next] = curl_init();
	                $options[CURLOPT_URL] = $urls[$next];//将下一个请求添加到队列 
	                curl_setopt_array($ch[$next],$options);
	                curl_multi_add_handle($mh, $ch[$next]);
	
	                // remove the curl handle that just completed
	                curl_multi_remove_handle($mh, $done['handle']);
	            } else {
	                // request failed.  add error handling.
	            }
	        }
    	} while ($running);
		
		curl_multi_close($mh);
		sleep(2);
		return false;
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