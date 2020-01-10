<?php

namespace models;

use core\Model;

class MainModel extends Model
{
	public $error;
	
	function testInput($data) 
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	public function contactValidate($post) 
	{
		$post['name'] = $this->testInput($post['name']);
		$post['text'] = $this->testInput($post['text']);
		$post['email'] = $this->testInput($post['email']);
		$post['numPhone'] = $this->testInput($post['numPhone']);
		
		$nameLen = iconv_strlen($post['name']);
		$textLen = iconv_strlen($post['text']);
		$numPhoneLen = iconv_strlen($post['numPhone']);
		if ($nameLen < 3 or $nameLen > 20) 
		{
			$this->error = 'Имя должно содержать от 3 до 20 символов';
			return false;
		} 
		elseif (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) 
		{
			$this->error = 'E-mail указан неверно';
			return false;
		} 
		elseif ($textLen < 10 or $textLen > 500) 
		{
			$this->error = 'Сообщение должно содержать от 10 до 500 символов';
			return false;
		}
		elseif ($numPhoneLen < 10 or $numPhoneLen > 20) 
		{
			$this->error = 'Номер телефона должен содержать 10 до 20 символов';
			return false;
		}
		
		return true;
	}	
	
	public function bannersList($start, $count) 
	{
		$params = array(
			'count' => $count,
			'start' => $start,
		);
		
		return $this->db->row('SELECT * FROM banners ORDER BY id DESC LIMIT :start, :count', $params);
	}
	
	public function bannersCount() 
	{
		return $this->db->column('SELECT COUNT(id) FROM banners');
	}
	
	public function catalogsList($start, $count) 
	{
		$params = array(
			'count' => $count,
			'start' => $start,
		);
		
		return $this->db->row('SELECT * FROM catalogs ORDER BY id DESC LIMIT :start, :count', $params);
	}
	
	public function fullCatalogsList() 
	{
		return $this->db->row('SELECT * FROM catalogs ORDER BY id');
	}
	
	public function catalogsCount() 
	{
		return $this->db->column('SELECT COUNT(id) FROM catalogs');
	}
	
	public function getCatalogById($id) 
	{
		$params = array(
			'id' => $id,
		);
		
		return $this->db->row('SELECT * FROM catalogs WHERE id = :id', $params);
	}
	
	public function getCatalogByProduct($id) 
	{
		$params = array(
			'id' => $id,
		);
		
		return $this->db->row('SELECT c.* FROM catalogs c JOIN products p ON p.idCatalog = c.id WHERE p.id = :id', $params);
	}
	
	public function checkProductInCatalog($id) 
	{
		$params = array(
			'id' => $id,
		);
		
		return $this->db->row('SELECT * FROM products WHERE idCatalog = :id LIMIT 1', $params);
	}
	
	public function productsList($start, $count, $idCatalog) 
	{
		$params = array(
			'count' => $count,
			'start' => $start,
			'idCatalog' => $idCatalog,
		);
		
		return $this->db->row('SELECT * FROM products WHERE idCatalog = :idCatalog ORDER BY id DESC LIMIT :start, :count', $params);
	}
	
	public function productsCount($id) 
	{
		$params = array(
			'id' => $id,
		);
		
		return $this->db->column('SELECT COUNT(id) FROM products WHERE idCatalog = :id', $params);
	}
	
	public function searchProducts($start, $count, $text) 
	{
		$params = array(
			'text' => $text,
			'start' => $start,
			'count' => $count,
		);
		
		return $this->db->row("SELECT * FROM products WHERE title LIKE CONCAT('%',:text,'%') ORDER BY id DESC LIMIT :start, :count", $params);
	}
	
	public function searchCount($text) 
	{
		$params = array(
			'text' => $text,
		);
		
		return $this->db->column("SELECT COUNT(id) FROM products WHERE title LIKE CONCAT('%',:text,'%')", $params);
	}
}

?>