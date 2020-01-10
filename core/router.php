<?php

namespace core;
/*
<?php

$str = 'foobar: 2008';

preg_match('/(?P<name>\w+): (?P<digit>\d+)/', $str, $matches);

 Это также работает в PHP 5.2.2 (PCRE 7.0) и более поздних версиях,
   однако вышеуказанная форма рекомендуется для обратной совместимости 
// preg_match('/(?<name>\w+): (?<digit>\d+)/', $str, $matches);

print_r($matches);

?>

https://www.php.net/manual/ru/function.preg-replace.php
*/
use core\View;

class Router
{
	protected $routes = array();
	protected $params = array();
	
	public function __construct()
	{
		$arr = require 'config/routesConfig.php';
		foreach($arr as $key => $val)
		{
			$this->add($key, $val);
		}
	}
	
	public function add($route, $params)
	{
		$route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
		$route = '#^'.$route.'$#u';
		$this->routes[$route] = $params;
	}

	public function match()
	{
		$url = trim($_SERVER['REQUEST_URI'], '/');
		
				
			
        foreach ($this->routes as $route => $params) 
		{
			$searchStr = explode('/', $url);
			if($searchStr[0] == 'search')
			{
				$key = 'text';
				$params['controller'] = 'main';
				$params['action'] = 'search';
				if(isset($searchStr[1]))
				{
					$params['text'] = $searchStr[1];
				}
				else
				{
					$params['text'] = "Ошибка ввода. Некорректные символы";
				}
				$this->params = $params;
				return true;
			}	
			
            if (preg_match($route, $url, $matches))
			{
                foreach ($matches as $key => $match) 
				{
                    if (is_string($key)) 
					{
                        if (is_numeric($match)) 
						{
							$match = (int) $match;
                        }
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
	}
	
	public function run()
	{
		if($this->match())
		{
			$path = 'controllers\\'.ucfirst($this->params['controller']).'Controller';
			if(class_exists($path))
			{
				$action = $this->params['action'].'Action';
				if(method_exists($path, $action))
				{
					$controller = new $path($this->params);
					$controller->$action();
				}
				else
				{
					View::errorCode(404);
				}
			}
			else
			{
				View::errorCode(404);
			}
		}
		else
		{
			View::errorCode(404);
		}
	}
}