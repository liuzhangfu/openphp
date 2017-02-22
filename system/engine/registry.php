<?php
/**
 * 注册对象类
 *
 */
final class Registry
{
	static private $data = array();
	
	static public function get($key)
	{
		return isset(self::$data[$key]) ? self::$data[$key] : null;
	}
	
	static public function set($key, $value)
	{
		self::$data[$key] = $value;
	}
	
	static public function has($key)
	{
		return self::$data[$key];
	}
}

?>