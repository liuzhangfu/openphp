<?php
final class DB
{
	private $driver;
	
	public function __construct($driver, $hostname, $username, $password, $database)
	{
		$file = DIR_DATABASE . $driver . '.php';
		
		if (file_exists($file)) {
			require_once($file);
		} else {
			exit('Error: Could not load database file ' . $driver . '!');
		}
		
		$this->driver = new $driver($hostname, $username, $password, $database);
	}
	
	public function query($sql)
	{
		$this->driver->query($sql);
	}
	
	public function escape($value)
	{
		return $this->driver->escape($value);
	}
	
  	public function countAffected()
  	{
		return $this->driver->countAffected();
  	}

  	public function getLastId()
  	{
		return $this->driver->getLastId();
  	}	
}

?>