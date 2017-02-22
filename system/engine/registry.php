<?php
/**
 * 注册对象类
 * 注册表模式(多个类的注册)是PHP设计模式，注册表的作用是提供系统级别的对象访问功能。有的同学会说，
 * 这样是多此一举，不过小项目中的确没有必要对类进行注册，如果是大项目，还是非常有用的。
 */
final class Registry
{
	//private static $instance; // 单例模式 
	
	static private $data = array();
	
	//private function __construct(){}//这个用法决定了这个类不能直接实例化 
	
	/*
	static function instance()
	{
		if (!isset(self::$instance)) {
			self::$instance = new self();
		} 
		return self::$instance; 
	}
	*/
	
	// 获取已经注册了的类 
	static public function get($key)
	{
		return isset(self::$data[$key]) ? self::$data[$key] : null;
	}
	
	// 注册类方法 
	static public function set($key, $value)
	{
		self::$data[$key] = $value;
	}
	
	// 检查是否己注册类方法 
	static public function has($key)
	{
		return self::$data[$key];
	}
}

?>