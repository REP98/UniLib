<?php
if (!defined("DS")) {
	define("DS", DIRECTORY_SEPARATOR);
}

if (!defined("ROOT_PATH")) {
	define("ROOT_PATH", __DIR__.DS);
}

require "vendor/autoload.php";

use UniLib\Core;

Core::start([
	"route" => ROOT_PATH.'route.php',
	"config" => ROOT_PATH.'setting.php',
]);
