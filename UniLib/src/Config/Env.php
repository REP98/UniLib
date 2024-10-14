<?php
declare(strict_types=1);

namespace UniLib\Config;

use UniLib\Traits\Singleton;
use Dotenv\Dotenv;
/**
 * Env
 * @see  https://github.com/vlucas/phpdotenv
 */
class Env
{
	use Singleton;
	
	private Dotenv $doenv;

	private function __construct() 
	{
		$rootPath = dirname(__DIR__, 4);
		if (defined("ROOT_PATH")) {
			$rootPath = ROOT_PATH;
		}
		$this->doenv = Dotenv::createImmutable($rootPath);
		$this->doenv->load();
		$this->validate();
	}

	private function validate() 
	{
		$this->doenv->required([
			'APP_NAME',
			'DB_NAME',
			/*"DB_USER",
			"DB_PASS"*/
		]);

		$this->doenv->required('DEBUG_MODE')->isBoolean();

		// OPCIONALES
		$this->doenv->ifPresent('DB_TYPE')->allowedValues([
			'mariadb',
			'mysql',
			'mssql',
			'pgsql',
			'sybase',
			'oracle',
			'sqlite'
		]);

		$this->doenv->ifPresent('DB_LOG')->isBoolean();
	}
	/**
	 * Obtiene valores de un .env según la .env
	 * @param  string $key     La clave
	 * @param  mixed $default El valor por defecto en caso de error
	 * @return mixed
	 */
	public function get(string $key, $default = null) 
	{
		return $_ENV[$key] ?? $default;
	}
}

?>
