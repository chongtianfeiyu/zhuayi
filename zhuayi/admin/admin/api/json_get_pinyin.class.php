<?php
/*
 * json_get_pinyin.php     Zhuayi 生成拼音
 *
 * @copyright    (C) 2005 - 2010  zhuayi
 * @licenes      http://www.zhuayi.net
 * @lastmodify   2010-10-28
 * @author       zhuayi
 * @QQ			 2179942
 */
class json_get_pinyin extends zhuayi
{

	function __construct()
	{
		parent::__construct();
	}

	function run($title)
	{
		print_r($this->load_fun('pinyin',urldecode($title)));
		
	}

}