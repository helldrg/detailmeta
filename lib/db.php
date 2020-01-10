<?php

namespace lib;

use PDO;

class Db
{
	protected $db;
	
	public function __construct()
	{
		//$config['name'].';charset=utf8;', $config['user']
		//$this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['dbname'], $config['user'], $config['password'],
        //array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
		$config = require 'config/dbConfig.php';
		$this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['name'].'',$config['user'],$config['password']);
	}
	
	public function query($sql, $params = array())
	{
		$stmt = $this->db->prepare($sql);
		if(!empty($params))
		{
			foreach($params as $key =>$val)
			{
				if (is_int($val)) 
				{
					$type = PDO::PARAM_INT;
				} else 
				{
					$type = PDO::PARAM_STR;
				}
				$stmt->bindValue(":".$key, $val, $type);
				
			}
		}
		$stmt->execute();
		
		//$stmt = $this->db->prepare($sql);
		//$stmt->execute($params);

		return $stmt;
	}
	
	public function row($sql, $params = array())
	{
		$result = $this->query($sql, $params);
		return $result->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function column($sql, $params = array())
	{
		$result = $this->query($sql, $params);
		return $result->fetchColumn();
	}
	
	public function lastInsertId() 
	{
		return $this->db->lastInsertId();
	}
}