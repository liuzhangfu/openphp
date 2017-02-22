<?php
/**
 * mysql数据库驱动
 * 
 */
final class MySQL extends Database
{
	private $connection;
	
	public function __construct($hostname, $username, $password, $database)
	{
		if (!$this->connection = mysql_connect($hostname, $username, $password)) {
			exit('Error: Could not make a database connection using ' . $username . '@' . $hostname);
		}
		
		if (!mysql_select_db($database, $this->connection)) {
			exit('Error: Could not connect to database ' . $database);
		}
		
		mysql_query("SET NAMES 'utf8'", $this->connection);
		mysql_query("SET CHARACTER SET utf8", $this->connection);
		mysql_query("SET CHARACTER_SET_CONNECTION=utf8", $this->connection);
		mysql_query("SET SQL_MODE = ''", $this->connection);
	}
	
	public function query($sql)
	{
		$resource = @mysql_query($sql, $this->connection)
					or $this->sqlerrorhandler("(".mysql_errno().") ".mysql_error(), $sql, $_SERVER['PHP_SELF'], __LINE__);
		
		if ($resource) {
			if (is_resource($resource)) {
				$i = 0;
				
				$data = array();
				
				while ($result = mysql_fetch_assoc($resource)) {
					$data[$i] = $result;
					
					$i++;
				}
				
				mysql_free_result($resouce);
				
				$recordset = new stdClass();
				$recordset->row = isset($data[0]) ? $data[0] : array();
				$recordset->rows = $data;
				$recordset->nums = $i;
				
				unset($data);
				
				return $recordset;
			} else {
				return true;
			}
		} else {
			exit('Error: ' . mysql_error($this->connection) . '<br />Error No: ' . mysql_errno($this->connection) . '<br />' . $sql);
		}
	}
	
	public function sqlerrorhandler($ERROR, $QUERY, $PHPFILE, $LINE){
	    define("SQLQUERY", $QUERY);
	    define("SQLMESSAGE", $ERROR);
	    define("SQLERRORLINE", $LINE);
	    define("SQLERRORFILE", $PHPFILE);
	    trigger_error("(SQL)", E_USER_ERROR);
	}
	
	/**
	 * 过滤，防止sql注入
	 *
	 */
	public function escape($value)
	{
		return mysql_real_escape_string($value, $this->connection);
	}
	
	public function countAffected()
	{
		return mysql_affected_rows($this->connection);
	}
	
	public function getLastId()
	{
		return mysql_insert_id($this->connection);
	}
	
	public function __destruct()
	{
		mysql_close($this->connection);
	}
}

?>