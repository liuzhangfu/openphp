<?php
/**
 * 配置类
 *
 */
final class Config
{
	private $data = array();
	
	public function get($key)
	{
		return (isset($this->data[$key]) ? $this->data[$key] : null);
	}
	
	public function set($key, $value)
	{
		$this->data[$key] = $value;
	}
	
	public function __get($key) {
		return Registry::get($key);
	}

	public function __set($key, $value) {
		Registry::set($key, $value);
	}
	
	public function has($key)
	{
		return isset($this->data[$key]);
	}
	
	/**
	 * 载入配置文件中的配置信息
	 *
	 * @param unknown_type $filename
	 */
	public function loadFromFile($filename)
	{
		$file = DIR_CONFIG . $filename . '.php';
		
		if (file_exists($file)) {
			$cfg = array();
			
			require($file);
			
			$this->data = array_merge($this->data, $cfg);
		} else {
			exit('Error: Could not load config ' . $filename . '!');
		}
	}
	
	/**
	 * 载入数据库中的配置信息
	 *
	 */
	public function loadFromDB()
	{
		// 此处根据具体的系统进行完善
	}
}

?>