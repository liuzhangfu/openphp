<?php
/**
 * 数据库抽象基类
 *
 */
abstract class Database
{
	abstract public function query($sql);
	
	abstract public function escape($value);
	
	abstract public function countAffected();
	
	abstract public function getLastId();
}

?>