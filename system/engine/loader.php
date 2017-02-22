<?php
/**
 * 载入类
 *
 */
final class Loader {
	public function __get($key) {
		return Registry::get($key);
	}

	public function __set($key, $value) {
		Registry::set($key, $value);
	}
	
	/**
	 * 加载类库文件
	 *
	 */
	public function library($library)
	{
		$file = DIR_SYSTEM . 'library/' . $library . '.php';
		
		if (file_exists($file)) {
			include_once($file);
		} else {
			exit('Error: Could not load library ' . $library . '!');
		}
	}
	
	/**
	 * 加载帮助库文件
	 * 
	 */
	public function helper($helper)
	{
		$file = DIR_SYSTEM . 'helper/' . $helper . '.php';
	
		if (file_exists($file)) {
			include_once($file);
		} else {
			exit('Error: Could not load helper ' . $helper . '!');
		}
	}
	
	/**
	 * 加载模型
	 *
	 */
	public function model($model)
	{
		$file  = DIR_APPLICATION . 'model/' . $model . '.php';
		$class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', $model);
		
		if (file_exists($file)) {
			include_once($file);
			
			Registry::set('model_' . str_replace('/', '_', $model), new $class());
		} else {
			exit('Error: Could not load model ' . $model . '!');
		}
	}
	
	/**
	 * 加载数据库驱动
	 *
	 */
	public function database($driver, $hostname, $username, $password, $database, $prefix = NULL, $charset = 'UTF8')
	{
		$file  = DIR_SYSTEM . 'database/' . $driver . '.php';
		$class = 'Database' . preg_replace('/[^a-zA-Z0-9]/', '', $driver);
		
		if (file_exists($file)) {
			include_once($file);
			
			Registry::set(str_replace('/', '_', $driver), new $class());
		} else {
			exit('Error: Could not load database ' . $driver . '!'); 
		}
	}
	
	/**
	 * 加载文件中的配置信息
	 *
	 */
	public function configFromFile($config)
	{
		$this->config->loadFromFile($config);
	}
	
	/**
	 * 加载数据库中的配置信息
	 * 
	 */
	public function configFromDB($config)
	{
		$this->config->loadFromDB();
	}
}

?>