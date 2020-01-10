<?php
// Debug
// file_put_contents('error.log', var_export($e,1));
// file_put_contents('error.log', $id, FILE_APPEND | LOCK_EX);
// Version php 5.3.13
// phpinfo();

// Если не работает spl_autoload_register
/*
require 'lib/dev.php';
require 'lib/db.php';
require 'core/router.php';//
require 'core/view.php';//
require 'core/model.php';//
require 'core/controller.php';//
require 'models/adminModel.php';//
require 'models/mainModel.php';//
require 'controllers/adminController.php';//
require 'controllers/mainController.php';//
*/
require 'lib/dev.php';

use core\Router;

spl_autoload_register(function($class){
	$path = str_replace('\\', '/', $class.'.php');
	if(file_exists($path))
	{
		require $path;
	}
});

session_start();

$router = new Router;
$router->run();