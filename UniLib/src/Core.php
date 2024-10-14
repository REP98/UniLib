<?php
declare(strict_types=1);

namespace UniLib;

use UniLib\Config\Config;
use UniLib\Config\Env;
use UniLib\Files\Log;
use UniLib\Router\Route;
use UniLib\Utils\Session;

/**
 * Core
 */
class Core
{
	private static $Config;
	private static $callBackBefore;


	public static function set_config(string $path) 
	{
		self::$Config = Config::I($path);
	}

	public static function set_route(string $fileRouters)
	{
		return Route::init($fileRouters, config('route'));
	}

	public static function config($key, $default) {
		return self::$Config->get($key, $default);
	}

	public static function before(Callable $callback) 
	{
		self::$callBackBefore = $callback;
	}

	public static function start(array $config) {
		$Config = array_merge([
			'route' => 'route.php',
			'config' => 'setting.php'
		], $config);

		Session::I();

		self::set_config($Config['config']);
		
		Env::I();

		Log::init();

		if (isset(self::$callBackBefore) && is_callable(self::$callBackBefore)) {
			call_user_func(self::$callBackBefore, []);
		}

		self::set_route($Config['route']);
	}
}
?>