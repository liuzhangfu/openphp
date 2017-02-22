<?php

// 载入配置
require_once('config.php');

// 启动框架
require_once(DIR_SYSTEM . 'startup.php');

// 数据库对象
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
Registry::set('db', $db);


// 配置对象
$config = new Config();
Registry::set('config', $config);

// 载入对象
$loader = new Loader();
$loader->configFromFile('app_config');
Registry::set('loader', $loader);

// 日志对象
$log = new Logger();
$log->setErroLogFile($config->get('log_error_file'));
$log->setSqlLogFile($config->get('log_sql_file'));
$log->setErrorHandler();
Registry::set('log', $log);

// 注册缓存对象
Registry::set('cache', new Cache());

// 注册url对象
Registry::set('url', new Url());

// session对象
$session = new Session();
Registry::set('session', $session);

// 注册页面文档对象
Registry::set('document', new Document());

// 请求对象
$request = new Request();
Registry::set('request', $request);

if (isset($request->get['route'])) {
	$action = new Action($request->get['route']);
} else {
	$action = new Action('common/home');
}

// 控制器对象
$controller = new Front();

// 响应对象
$response = new Response();
$response->addHeaders('Content-Type', 'text/html; charset=utf-8');
Registry::set('response', $response);


$controller->dispatch($action, new Action('error/not_found'));

$response->output();

?>