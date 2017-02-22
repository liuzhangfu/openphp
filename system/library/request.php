<?php
/**
 * 请求类
 *
 */
final class Request
{
	public $get = array();
	
	public $post = array();
	
	public $files = array();
	
	public $cookie = array();
	
	public $server = array();
	
	/**
	 * 构造函数
	 *
	 */
	public function __construct()
	{
		$this->get = $this->clean($_GET);
		$this->post = $this->clean($_POST);
		$this->files = $this->clean($_FILES);
		$this->cookie = $this->clean($_COOKIE);
		$this->server = $this->clean($_SERVER);
	}
	
	/**
	 * 转义特殊字符
	 *
	 */
	public function clean($data) {
    	if (is_array($data)) {
	  		foreach ($data as $key => $value) {
				unset($data[$key]);
				
	    		$data[$this->clean($key)] = $this->clean($value);
	  		}
		} else { 
	  		$data = htmlentities($data, ENT_QUOTES, 'UTF-8');
		}

		return $data;
	}
}

?>