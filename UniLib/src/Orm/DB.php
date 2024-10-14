<?php
declare(strict_types=1);

namespace UniLib\Orm;

use Medoo\Medoo;
use PDO;

/**
 * DB
 * Conección con base de datos con el poder de Medoo
 * @see  https://medoo.in/api/new
 */
class DB extends Medoo
{
	private static $instance = null;

	protected function __construct(?array $config = [])
	{
		$settings = [
			// [optional]
			'charset' => env('DB_CHARSET','utf8mb4'),
			'collation' => env('DB_COLLATION','utf8mb4_general_ci'),
			'port' => env('DB_PORT', 3306),
		 
			// [optional] The table prefix. All table names will be prefixed as PREFIX_table.
			'prefix' => env('DB_PREFIX', null),
		 
			// [optional] To enable logging. It is disabled by default for better performance.
			'logging' => env('DB_LOG', false),
		 
			// [optional]
			// Error mode
			// Error handling strategies when the error has occurred.
			// PDO::ERRMODE_SILENT (default) | PDO::ERRMODE_WARNING | PDO::ERRMODE_EXCEPTION
			// Read more from https://www.php.net/manual/en/pdo.error-handling.php.
			'error' => env('DB_ERRMODE',  env("DEBUG_MODE", PDO::ERRMODE_SILENT) ),
		 
			// [optional]
			// The driver_option for connection.
			// Read more from http://www.php.net/manual/en/pdo.setattribute.php.
			'option' => [
				PDO::ATTR_CASE => PDO::CASE_NATURAL
			],
		 
			// [optional] Medoo will execute those commands after the database is connected.
			'command' => [
				'SET SQL_MODE=ANSI_QUOTES'
			]
		];
		// Required
		$type = env('DB_TYPE', 'mysql');

		if ($type == 'mysql' && env('DB_SOCKET' , false)) {
			$settings['socket'] = env('DB_SOCKET');
		}

		if ($type == 'mssql') {
			if (env('DB_APPNAME', false)) {
				$settings['appname'] = env('DB_APPNAME');
			}
			$settings['driver'] = env('DB_DRIVER', 'sqlsrv');
		} 

		if (!empty($config)) {
			$settings = array_merge($settings, $config);
		}


		if ($type == 'sqlite') {
			parent::__construct(array_merge([
				'type' => 'sqlite',
				'database' => env('DB_NAME')
			], $settings));
		} else {
			parent::__construct(array_merge([
				'type' => $type,
				'host' => env('DB_HOST','localhost'),
				'database' => env('DB_NAME'),
				'username' => env('DB_USER'),
				'password' => env('DB_PASS')
			], $settings));
		}
	}

	/**
	 * Permite la conexion con la DB
	 * @param array $config Configuraciónes adicionales a la DB
	 * @return  \Medoo\Medoo
	 */
	public static function Connection(?array $config = []): Medoo
	{
		if (self::$instance == null) {
			self::$instance = new self($config);
		}

		return self::$instance;
	}
	/**
	 * Reinicia la conexion
	 * @return \Medoo\Medoo
	 */
	public static function reset(): Medoo
	{
		self::$instance = null;
		return self::Connection();
	}
}