<?php
/**
 * --------------------------------
 * Zhuayi 网站名称
 * --------------------------------
 */ 
$config['web']['webname'] = '软件管理平台';
$config['web']['appname'] = 'soft';

/**
 * --------------------------------
 * Zhuayi 网站地址
 * --------------------------------
 */
$config['web']['weburl'] = 'http://'.$_SERVER['HTTP_HOST'].'/zpadmin';
$config['web']['error_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/soft/zpadmin?redirect=1';


/**
 * --------------------------------
 * Zhuayi 是否debug模式 
 * --------------------------------
 */
$config['debug'] = true;

/**
 * --------------------------------
 * Zhuayi URL路由 默认控制器
 * --------------------------------
 */
$config['url_config']['default'] = 'index';

/**
 * --------------------------------
 * Zhuayi URL路由,键值支持正则
 * --------------------------------
 */

/* 是否开启二级域名支持 */
$config['url_domain'] = false;

/* 后台rewrite规则 */
$config['url_config']['routing']['^\/admin(.*)'] = '/error/$1';
$config['url_config']['routing']['^\/zpadmin(.*)'] = '/admin$1';


/* 用户反馈路由 */
$config['url_config']['routing']['^\/fqa\/project_([0-9]+).html'] = '/fqa/lists/$1';
$config['url_config']['routing']['^\/fqa\/question_([0-9]+).html'] = '/fqa/question/$1';
/**
 * --------------------------------
 * Zhuayi 缓存配置
 * --------------------------------
 */
$config['cache']['outtime'] = 86400;
$config['cache']['list_outtime'] = 3600;
/**
 * ----------------------------------------------------
 * Zhuayi 是否开启错误推送
 * ----------------------------------------------------
 */
$config['email_debug'] = false;
$config['email_debug_adress'][] = '2179942@qq.com';




/* cron 接收邮件 */
$config['app_config']['accept_email'] = '2179942@qq.com';
?>