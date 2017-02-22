<?php

final class Action
{
	protected $filepath;
	
	protected $method;
	
	protected $args = array();
	
	/**
	 * 构造函数
	 *
	 */
	public function __construct($route, $args = array())
	{
		$path = '';
		
		$parts = explode('/', str_replace('../', '', $route));
		
		foreach ($parts as $part) { 
			$path .= $part;
			
			if (is_dir(DIR_APPLICATION . 'controller/' . $path)) {
				$path .= '/';
				
				array_shift($parts);
				
				continue;
			}
			
			if (is_file(DIR_APPLICATION . 'controller/' . $path . '.php')) {
				$this->filepath = $path;

				array_shift($parts);
				
				break;
			}
			
			if ($args) {
				$this->args = $args;
			}
		}
		
		$method = array_shift($parts);
		
		if ($method) {
			$this->method = 'action' . $method;
		} else {
			$this->method = 'actionIndex';
		}
	}
	
	public function getFilePath()
	{
		return $this->filepath;
	}
	
	public function getMethod()
	{
		return $this->method;
	}
	
	public function getArgs()
	{
		return $this->args;
	}
}

?>