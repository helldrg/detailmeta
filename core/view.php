<?php

namespace core;

class View
{
	public $path;
	public $route;
	public $layout = 'default';
	
	public function __construct($route)
	{
		$this->route = $route;
		$this->path = $route['controller'].'/'.$route['action'];
	}
	
	private function GetVars()
	{
		$buffer = array();
		$handle=fopen("config/settingsConfig.ini","r");
		
		$i = 0;
		while (!feof($handle)) 
		{
			$buffer[$i++] = explode("'", fgets($handle, 1024));//preg_match('/".*"/', $buffer[$i], $matches);
		}
		fclose($handle);
		
		$vars = array(
			'domen' => $buffer['0'][1],
			'vkGroup' => $buffer['1'][1],
			'orgName' => $buffer['2'][1],
			'mainNumPhone' => $buffer['3'][1],
		);
		
		return $vars;
	}
	
	public function render($title, $vars = array())
	{
		extract($vars);
		
		$path = 'views/'.$this->path.'View.php';
		if(file_exists($path))
		{
			ob_start();
			require $path;
			$content = ob_get_clean();
			$vars = $this->GetVars();
			require 'views/layouts/'.$this->layout.'Layout.php';
		}
		else
		{
			View::errorCode(404);
		}
	}
	
	// Main renders
	public function renderProductsList($title, $vars = array())
	{
		extract($vars);
		$path = 'views/main/productListView.php';
		if(file_exists($path))
		{
			ob_start();
			require $path;
			$content = ob_get_clean();
			$vars = $this->GetVars();
			require 'views/layouts/defaultLayout.php';
		}
		else
		{
			View::errorCode(404);
		}
	}
	
	public function renderProductsMainAjax($vars = array())
	{
		$path = 'views/main/ajax/productsMainAjax.php';
		extract($vars);
		if(file_exists($path))
		{
			require $path;
		}
		else
		{
			View::errorCode(404);
		}
	}
	
	public function renderCatalogsMainAjax($vars = array())
	{
		$path = 'views/main/ajax/catalogsMainAjax.php';
		extract($vars);
		if(file_exists($path))
		{
			require $path;
		}
		else
		{
			View::errorCode(404);
		}
	}
	

	public function renderBannersMainAjax($vars = array())
	{
		$path = 'views/main/ajax/bannersMainAjax.php';
		extract($vars);
		if(file_exists($path))
		{
			require $path;
		}
		else
		{
			View::errorCode(404);
		}
	}
	
	public function renderSearchMainAjax($vars = array())
	{
		$path = 'views/main/ajax/searchMainAjax.php';
		
		extract($vars);
		if(file_exists($path))
		{
			require $path;
		}
		else
		{
			View::errorCode(404);
		}
	}
	
	// Admin renders
	public function renderBannersAdminAjax($vars = array())
	{
		$path = 'views/admin/adminAjax/bannersAdminAjax.php';
		extract($vars);
		if(file_exists($path))
		{
			require $path;
		}
		else
		{
			View::errorCode(404);
		}
	}
	
	public function renderCatalogsAdminAjax($vars = array())
	{
		$path = 'views/admin/adminAjax/catalogsAdminAjax.php';
		extract($vars);
		if(file_exists($path))
		{
			require $path;
		}
		else
		{
			View::errorCode(404);
		}
	}
	
	public function renderProductsListAdmin($title, $vars = array())
	{
		extract($vars);
		$path = 'views/admin/viewProductListView.php';
		if(file_exists($path))
		{
			ob_start();
			require $path;
			$content = ob_get_clean();
			$vars = $this->GetVars();
			require 'views/layouts/adminLayout.php';
		}
		else
		{
			View::errorCode(404);
		}
	}
	
	public function renderProductsListAdminAjax($vars = array())
	{
		$path = 'views/admin/adminAjax/productListAdminAjax.php';
		extract($vars);
		if(file_exists($path))
		{
			require $path;
		}
		else
		{
			View::errorCode(404);
		}
	}
		
	public function redirect($url)
	{
		header('location: /'.$url);
		exit;
	}
	
	public static function errorCode($code)
	{
		header('HTTP/1.0 404 Not Found', true, $code);
		$path = 'views/errors/'.$code.'View.php';
		if(file_exists($path))
		{
			require $path;
		}
		exit;
	}
	
	public function message($status, $message)
	{
		exit(json_encode(array('status' => $status, 'message' => $message)));
	}
	
	public function location($url)
	{
		exit(json_encode(array('url' => $url)));
	}
	
	public function locationAndMessage($url, $status, $message)
	{
		exit(json_encode(array('url' => $url,'status' => $status, 'message' => $message)));
	}
}