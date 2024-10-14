<?php
declare(strict_types=1);

require __DIR__.'/../vendor/pecee/simple-router/helpers.php';

use UniLib\Core;
use UniLib\Config\Env;
use UniLib\Utils\Session;
use UniLib\Views\Engine;

if (!function_exists('env')) {
	function env(string $key, $default = null) {
		return Env::I()->get($key, $default);
	}
}

if (!function_exists('config')) {
	function config(string $key, $default = null) {
		return Core::config($key, $default);
	}
}

if (!function_exists('view')) {
	function view(string $tpl, array $data = [])
	{
		return Engine::render($tpl, $data);
	}
}

if (!function_exists('session')) {
	function session() {
		return Session::I();
	}
}

?>