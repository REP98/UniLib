<?php
if (!defined("DS")) {
	define("DS", DIRECTORY_SEPARATOR);
}

if (!defined("ROOT_PATH")) {
	define("ROOT_PATH", __DIR__.DS);
}

if (!defined('APP_PATH')) {
	define('APP_PATH', ROOT_PATH.'app'.DS);
}

require "vendor/autoload.php";

use UniLib\Core;
use UniLibDemo\Demo;

Core::before(function(){
	// Creamos la DB si no existe
	Demo::createDB();
});

Core::start([
	"route" => APP_PATH.'route.php',
	"config" => ROOT_PATH.'config'.DS.'setting.php',
]);