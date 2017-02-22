<?php

// 网站地址
define('HTTP_SERVER', 'http://localhost/openphp/');		// HTTP地址，可以根据需求加上HTTPS，支持SSL

// 数据库配置
define('DB_DRIVER', 'mysql');				// 数据库类型，暂时支持mysql和mssql
define('DB_HOSTNAME', 'localhost');			// 主机
define('DB_USERNAME', 'root');				// 数据库用户名
define('DB_PASSWORD', '123');				// 数据库密码
define('DB_DATABASE', 'opencart');			// 数据库名
define('DB_PREFIX', '');					// 数据库表名前缀

// 全局目录配置
define('DIR_ROOT', 			dirname(__FILE__));						// 根目录
define('DIR_APPLICATION', 	DIR_ROOT . '/catalog/');				// 前台目录
define('DIR_SYSTEM', 		DIR_ROOT . '/system/');					// 框架目录
define('DIR_TEMPLATE', 		DIR_ROOT . '/catalog/view/theme/');		// 模板目录
define('DIR_CONFIG', 		DIR_ROOT . '/system/config/');			// 配置目录
define('DIR_DATABASE', 		DIR_ROOT . '/system/database/');		// 数据库驱动目录
define('DIR_LOGS', 			DIR_ROOT . '/system/logs/');			// 日志目录
define('DIR_CACHE', 		DIR_ROOT . '/system/cache/');			// 缓存目录

?>