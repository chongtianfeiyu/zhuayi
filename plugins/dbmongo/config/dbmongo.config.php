<?php
return array(
				'host' => '10.52.176.33', // 服务器
				'port' => '27017', // port
				'connect' => true, // true表示Mongo构造函数中建立连接。
				'timeout'=> 5, // 配置建立连接超时时间，单位是ms
				'replicaSet'=>'name', // 配置replicaSet名称
				'username'=>'', // 覆盖$server字符串中的username段，如果username包含冒号:时，选用此种方式。
				'password'=>'' // 覆盖$server字符串中的password段，如果password包含符号@时，选用此种方式。
			);

?>