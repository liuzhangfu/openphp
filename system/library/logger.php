<?php
/**
 * 日志类
 *
 */
final class Logger
{
	private $error_log;
	
	private $sql_log;
	
	public function write($file, $message)
	{
		$file = DIR_LOGS . $file;
		
		$handle = fopen($file, 'a+'); 
		
		fwrite($handle, date('Y-m-d G:i:s') . ' - ' . $message . "\n");
			
		fclose($handle); 
	}
	
	public function setErroLogFile($filename)
	{
		$this->error_log = $filename;
	}
	
	public function setSqlLogFile($filename)
	{
		$this->sql_log = $filename;
	}
	
	public function setErrorHandler()
	{
		set_error_handler(array(&$this, 'error_handler'));
	}
	
	/**
	 * 自定义的错误处理函数
	 *
	 * 可以根据具体情况设置输出时过滤掉一些路径，避免暴露给客户端
	 * 
	 */
	public function error_handler($errno, $errstr, $errfile, $errline)
	{
		$config = Registry::get('config');
		
		switch ($errno) {
			case E_NOTICE:
			case E_USER_NOTICE:
				$error = "Notice";
				break;
			case E_WARNING:
			case E_USER_WARNING:

				$error = "Warning";
				break;
			case E_ERROR:
			case E_USER_ERROR:
				if ($errstr == "(SQL)"){
					$error = "SQL Error";
		        } else {
		        	$error = "Fatal Error";
		        }
				break;
			default:
				$error = "Unknown";
				break;
		}
			
	    if ($config->get('error_display')) {
	    	if ($errstr == '(SQL)') {
	    		echo "<b>" . $error . "</b> [$errno] " . SQLMESSAGE . "<br />\n";
	            echo "Query : " . SQLQUERY . "<br />\n";
	            echo "On line " . SQLERRORLINE . " in file " . SQLERRORFILE . " ";
	            echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
	            echo "Aborting...<br />\n";
//	            exit(1);
	    	} else {
	        	echo '<b>' . $error . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
	    	}
		}
		
		if ($config->get('error_log')) {
			if ($errstr == '(SQL)') {
				if (!is_null($this->sql_log)) {
					$this->write($this->sql_log, $error . ":\n" . SQLMESSAGE . "\nQuery : \"" . SQLQUERY . "\"\nOn line " . SQLERRORLINE . " in file " . SQLERRORFILE . "\n");
					exit(1);
				}
	    	} else {
	    		if (!is_null($this->error_log)) {
	    			$this->write($this->error_log, 'PHP ' . $error . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
	    		}
	    	}
		}
	
		return TRUE;
	}
}

?>