<?php
/**
 * 响应类
 *
 */
final class Response
{
	private $headers = array();
	
	private $output;
	
	private $level;		// gzip或x-gzip压缩级别
	
	public function addHeaders($key, $value)
	{
		$this->headers[$key] = $value;
	}
	
	public function removeHeaders($key)
	{
		if (isset($this->headers[$key])) {
			unset($this->headers[$key]);
		}
	}
	
	public function redirect($url)
	{
		header('Location: ' . $url);
		exit;
	}
	
	/**
	 * 设置输出
	 *
	 * @param unknown_type $output 输出内容
	 * @param unknown_type $level gzip或x-gzip压缩级别
	 */
	public function setOutput($output, $level = 0)
	{
		$this->output = $output;
		$this->level = $level;
	}
	
	/**
	 * 压缩
	 *
	 */
	private function compress($data, $level = 0)
	{
		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false)) {
			$encoding = 'gzip';
		}
		
		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false)) {
			$encoding = 'x-gzip';
		}
		
		if (!isset($encoding)) {
			return $data;
		}

		// 只有加入了zlib扩展才能使用一些gzip压缩函数
		if (!extension_loaded('zlib') || ini_get('zlib.output_compression')) {
			return $data;
		}

		if (headers_sent()) {
			return $data;
		}

		if (connection_status()) { 
			return $data;
		}
		
		$this->addHeader('Content-Encoding', $encoding);

		return gzencode($data, (int)$level);
	}
	
	/**
	 * 输出
	 *
	 */
	public function output()
	{
		if ($this->level) {
			$output = $this->compress($this->output, $this->level);
		} else {
			$output = $this->output;
		}
		
		if (!headers_sent()) {
			foreach ($this->headers as $key => $value) {
				header($key . ':' . $value);
			}
		}
		
		echo $output;
	}
}

?>