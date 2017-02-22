<?php
/**
 * 控制器抽象基类
 *
 */
abstract class Controller
{
	protected $id;
	
	protected $template;
	
	protected $children = array();
	
	protected $data = array();
	
	protected $output;
	
	public function __get($key)
	{
		return Registry::get($key);
	}
	
	public function __set($key, $value)
	{
		return Registry::set($key, $value);
	}
	
	/**
	 * 跳转到指定url处
	 *
	 */
	protected function redirect($url)
	{
		header('Location:' . str_replace('&amp;', '&', $url));
		exit();
	}
	
	protected function forward($route, $args = array())
	{
		return new Action($route, $args);
	}
	
	protected function render($return = false)
	{
		foreach ($this->children as $child) {
			$file = DIR_APPLICATION . 'controller/' . str_replace('../', '', $child) . '.php';
			$class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $child);
			
			if (file_exists($file)) {
				require_once($file);
				
				$controller = new $class();
				
				$controller->actionIndex();
				
				$this->data[$controller->id] = $controller->output;
			} else {
				exit('Error: Could not load controller ' . $child . '!');
			}
		}
		
		if ($return) {
			return $this->fetch($this->template);
		} else {
			$this->output = $this->fetch($this->template);
		}
	}
	
	protected function fetch($filename)
	{
		$file = DIR_TEMPLATE . $filename;
		
		if (file_exists($file)) {
			extract($this->data);
			
			/**
			 * 此处主要是打开缓冲区，输出内容先不直接输出到浏览器，而是存到缓冲区，然后用变量$content存取
			 * 缓冲区中的输出内容，便于处理，比如可以用gzip压缩后再传到浏览器端等，然后清空缓冲区
			 */
			
			ob_start();
			
			require($file);
			
			$content = ob_get_contents();
			
			ob_end_clean();
			
			return $content;
		} else {
      		exit('Error: Could not load template ' . $file . '!');
    	}
	}

}

?>