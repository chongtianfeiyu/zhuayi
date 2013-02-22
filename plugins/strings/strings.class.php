<?php
/*
 * strings.php     Zhuayi 字符串操作类
 *
 * @copyright    (C) 2005 - 2010  zhuayi
 * @licenes      http://www.zhuayi.net
 * @lastmodify   2010-10-28
 * @author       zhuayi
 * @QQ			 2179942
 */

 class strings
 {
 	function __construct() 
 	{
 		
 	}

 	/**
 	 * limit 根据指定的字符数目对一段字符串进行截取
 	 *
 	 * 截取字符串(UTF-8)
	 *
	 * @param string $string 原始字符串
	 * @param $start 开始截取位置
	 * @param $len 需要截取的偏移量
	 * $type=1 等于1时末尾加'...'不然不加
 	 **/
	function limit($string, $start, $len, $byte=3)
 	{
 		$string = strip_tags(htmlspecialchars_decode($string));
 		if (empty($string))
 		{
 			return $string;
 		}
 		if(strlen($string)<3*$len)
 		{
 			return $string;
 		}
		
		$re = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
		preg_match_all($re, $string, $match);
		$string = join("",array_slice($match[0], $start, $len));
		return $string;
 	}

 	/**
 	 * iconvn 万能字符串转码
 	 *
 	 * @return void
 	 * @author 
 	 **/
	function iconvn($string,$outcode='utf-8//IGNORE')      
	{

		$incode = mb_detect_encoding($string, array('ASCII','gb2312','gbk','utf-8','utf-16'));

		if (empty($incode))
		{
			$incode = 'GBK';
		}
		if ($incode == $outcode)
		{
			return $string;
		}
		else
		{
			return iconv($incode,$outcode, $string);
		}
		return $encode;
	}

	/**
	 * replace_a 过滤HTML
	 *
	 * @return void
	 * @author 
	 **/
	function replace_a($string)
	{
		$string = htmlspecialchars_decode($string);
		$string =  preg_replace('/<a(.*?)href=(.*?)>(.*?)<\/a>/i',"$3" , $string);
		return htmlspecialchars($string);
	}

	/**
	 * strip 过滤HTML
	 *
	 * @return void
	 * @author 
	 **/
	function strip($string)
	{
		$string = htmlspecialchars_decode($string);
		return strip_tags($string);
	}

	/**
	 * mymd5 加密字符串
	 *
	 * @return void
	 * @author 
	 **/
	 function mymd5($string)
	 {
	 	return md5($string.md5($string));
	 }

	 /**
	 * compress 压缩字符串
	 *
	 * @return void
	 * @author 
	 **/
	function compress($string)
	{
	 	$string = preg_replace("/(^http:)*\/\/[\S^;]*;/","",$string);
		$string = preg_replace("/\<\!\-\-[\s\S]*?\-\-\>/","",$string);
		$string = preg_replace("/\>[\s]+\</","><",$string);
		$string = preg_replace("/;[\s]+/",";",$string);
		$string = preg_replace("/[\s]+\}/","}",$string);
		$string = preg_replace("/}[\s]+/","}",$string);
		$string = preg_replace("/\{[\s]+/","{",$string);
		$string = preg_replace("/([\s]){2,}/","$1",$string);
		return preg_replace("/[\s]+\=[\s]+/","=",$string);
	}

	function isUTF8($str)
	{
       if ($str === mb_convert_encoding(mb_convert_encoding($str, "UTF-32", "UTF-8"), "UTF-8", "UTF-32")) {
           return true;
       }
       else
       {
           return false;
       }
    }


    static function php_crc32($value)
	{
		
		return sprintf("%u", crc32($value));
		
	}

	function un_script_code($str)
	{
		$s			= array();
		$s["/<script[^>]*?>.*?<\/script>/si"] = "";
		return strings::filt_string($str, $s, true);
	}

	/**
	 * 过滤字符串中的特殊字符
	 * @return string
	 * @param string $str 需要过滤的字符
	 * @param string $filtStr 需要过滤字符的数组（下标为需要过滤的字符，值为过滤后的字符）
	 * @param boolen $regexp 是否进行正则表达试进行替换，默认false
	 */
	
	function filt_string($str, $filtStr, $regexp = false)
	{
		$str = htmlspecialchars_decode($str);

		if (!is_array($filtStr))
		{
			return $str;
		}
		$search		= array_keys($filtStr);
		$replace	= array_values($filtStr);
				
		if ($regexp)
		{
			return preg_replace($search, $replace, $str);
		}
		else
		{
			return str_replace($search, $replace, $str);
		}
	}
 }