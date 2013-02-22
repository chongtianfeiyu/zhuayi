<?php
return array(
				/* 默认数据库 */
				'default' =>  array(
									'mysql_host_m'        =>		SAE_MYSQL_HOST_M,
									'mysql_host_s'        =>		SAE_MYSQL_HOST_S,
									'mysql_user'          =>		SAE_MYSQL_USER,
									'mysql_pass'          =>	 	SAE_MYSQL_PASS,
									'mysql_db'            =>		SAE_MYSQL_DB,
									'mysql_port'          =>		SAE_MYSQL_PORT,
									'mysql_charset'       =>		"utf8",
									'mysql_pre'           =>		"",
									'mysql_cache_outtime' =>		'86400'
									),
				/* 软件管理器 */
				'soft' => array(
									'mysql_host_m'        =>		SAE_MYSQL_HOST_M,
									'mysql_host_s'        =>		SAE_MYSQL_HOST_S,
									'mysql_user'          =>		SAE_MYSQL_USER,
									'mysql_pass'          =>	 	SAE_MYSQL_PASS,
									'mysql_db'            =>		'SOFT_MGR_TEST3',
									'mysql_port'          =>		SAE_MYSQL_PORT,
									'mysql_charset'       =>		"utf8",
									'mysql_pre'           =>		"",
									'mysql_cache_outtime' =>		'86400'
									),
				/* 心跳服务 */
				'heartbeat' => array(
									'mysql_host_m'        =>		SAE_MYSQL_HOST_M,
									'mysql_host_s'        =>		SAE_MYSQL_HOST_S,
									'mysql_user'          =>		SAE_MYSQL_USER,
									'mysql_pass'          =>	 	SAE_MYSQL_PASS,
									'mysql_db'            =>		'heartbeat',
									'mysql_port'          =>		SAE_MYSQL_PORT,
									'mysql_charset'       =>		"utf8",
									'mysql_pre'           =>		"",
									'mysql_cache_outtime' =>		'86400'
									),

				/* 升级服务 */
				'update' => array(
									'mysql_host_m'        =>		SAE_MYSQL_HOST_M,
									'mysql_host_s'        =>		SAE_MYSQL_HOST_S,
									'mysql_user'          =>		SAE_MYSQL_USER,
									'mysql_pass'          =>	 	SAE_MYSQL_PASS,
									'mysql_db'            =>		'update',
									'mysql_port'          =>		SAE_MYSQL_PORT,
									'mysql_charset'       =>		"utf8",
									'mysql_pre'           =>		"",
									'mysql_cache_outtime' =>		'86400'
									),
				/* VDC服务 */
				'vdc' => array(
									'mysql_host_m'        =>		'10.52.176.32',
									'mysql_host_s'        =>		'10.52.176.32',
									'mysql_user'          =>		'vdc',
									'mysql_pass'          =>	 	'vdc',
									'mysql_db'            =>		'vdc_db',
									'mysql_port'          =>		SAE_MYSQL_PORT,
									'mysql_charset'       =>		"utf8",
									'mysql_pre'           =>		"",
									'mysql_cache_outtime' =>		'86400'
									),
				/* 引擎发布 */
				'release_log_db' => array(
									'mysql_host_m'        =>		'10.52.176.32',
									'mysql_host_s'        =>		'10.52.176.32',
									'mysql_user'          =>		'vdc',
									'mysql_pass'          =>	 	'vdc',
									'mysql_db'            =>		'release_log_db',
									'mysql_port'          =>		SAE_MYSQL_PORT,
									'mysql_charset'       =>		"utf8",
									'mysql_pre'           =>		"",
									'mysql_cache_outtime' =>		'86400'
									),
				/* 服务器数据上报 */
				'datav' => array(
									'mysql_host_m'        =>		SAE_MYSQL_HOST_M,
									'mysql_host_s'        =>		SAE_MYSQL_HOST_S,
									'mysql_user'          =>		SAE_MYSQL_USER,
									'mysql_pass'          =>	 	SAE_MYSQL_PASS,
									'mysql_db'            =>		'datav',
									'mysql_port'          =>		SAE_MYSQL_PORT,
									'mysql_charset'       =>		"utf8",
									'mysql_pre'           =>		"",
									'mysql_cache_outtime' =>		'86400'
									),
				/* 用户反馈系统 */
				'fqa' => array(
									'mysql_host_m'        =>		SAE_MYSQL_HOST_M,
									'mysql_host_s'        =>		SAE_MYSQL_HOST_S,
									'mysql_user'          =>		SAE_MYSQL_USER,
									'mysql_pass'          =>	 	SAE_MYSQL_PASS,
									'mysql_db'            =>		'fqa',
									'mysql_port'          =>		SAE_MYSQL_PORT,
									'mysql_charset'       =>		"utf8",
									'mysql_pre'           =>		"",
									'mysql_cache_outtime' =>		'86400'
									),
				/* 启动加速 */
				'startup' => array(
									'mysql_host_m'        =>		SAE_MYSQL_HOST_M,
									'mysql_host_s'        =>		SAE_MYSQL_HOST_S,
									'mysql_user'          =>		SAE_MYSQL_USER,
									'mysql_pass'          =>	 	SAE_MYSQL_PASS,
									'mysql_db'            =>		'opt_startup',
									'mysql_port'          =>		SAE_MYSQL_PORT,
									'mysql_charset'       =>		"utf8",
									'mysql_pre'           =>		"",
									'mysql_cache_outtime' =>		'86400'
									),
				/* 启动加速 */
				'system' => array(
									'mysql_host_m'        =>		SAE_MYSQL_HOST_M,
									'mysql_host_s'        =>		SAE_MYSQL_HOST_S,
									'mysql_user'          =>		SAE_MYSQL_USER,
									'mysql_pass'          =>	 	SAE_MYSQL_PASS,
									'mysql_db'            =>		'opt_system',
									'mysql_port'          =>		SAE_MYSQL_PORT,
									'mysql_charset'       =>		"utf8",
									'mysql_pre'           =>		"",
									'mysql_cache_outtime' =>		'86400'
									),
				/* 垃圾清理 */
				'garbage' => array(
									'mysql_host_m'        =>		SAE_MYSQL_HOST_M,
									'mysql_host_s'        =>		SAE_MYSQL_HOST_S,
									'mysql_user'          =>		SAE_MYSQL_USER,
									'mysql_pass'          =>	 	SAE_MYSQL_PASS,
									'mysql_db'            =>		'opt_garbage',
									'mysql_port'          =>		SAE_MYSQL_PORT,
									'mysql_charset'       =>		"utf8",
									'mysql_pre'           =>		"",
									'mysql_cache_outtime' =>		'86400'
									),
				/*字段管理*/
				'field' => array(
									'mysql_host_m'        =>		SAE_MYSQL_HOST_M,
									'mysql_host_s'        =>		SAE_MYSQL_HOST_S,
									'mysql_user'          =>		SAE_MYSQL_USER,
									'mysql_pass'          =>	 	SAE_MYSQL_PASS,
									'mysql_db'            =>		'doc',
									'mysql_port'          =>		SAE_MYSQL_PORT,
									'mysql_charset'       =>		"utf8",
									'mysql_pre'           =>		"",
									'mysql_cache_outtime' =>		'86400'
									),
				'exchange' => array(
									'mysql_host_m'        =>		SAE_MYSQL_HOST_M,
									'mysql_host_s'        =>		SAE_MYSQL_HOST_S,
									'mysql_user'          =>		SAE_MYSQL_USER,
									'mysql_pass'          =>	 	SAE_MYSQL_PASS,
									'mysql_db'            =>		'exchange',
									'mysql_port'          =>		SAE_MYSQL_PORT,
									'mysql_charset'       =>		"utf8",
									'mysql_pre'           =>		"",
									'mysql_cache_outtime' =>		'86400'
									)
			);

?>