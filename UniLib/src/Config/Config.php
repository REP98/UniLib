<?php
declare(strict_types=1);

namespace UniLib\Config;

use UniLib\Traits\Singleton;
use League\Config\Configuration;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Pecee\Http\Middleware\BaseCsrfVerifier;
use UniLib\Exceptions\UnsupportedExecption;

/**
 * Config
 * @see https://config.thephpleague.com/
 */
class Config
{
	use Singleton;

	private Configuration $setting;

	private function __construct(string $filePath)
	{
		$this->load($filePath);
	}

	private function defaultScheme(): array
	{
		return [
			// Información de Root
			'root' => Expect::structure([
				'path' => Expect::string()->default('ROOT_PATH')
			]),
			'log' => Expect::structure([
				'filename' => Expect::string()->default('unilib.log')
			]),
			// Router
			'route' => Expect::structure([
				"namespace" => Expect::string()->nullable(),
				'csrfVerifier' => Expect::type(BaseCsrfVerifier::class),
				'errview' => Expect::arrayOf(
           			Expect::listOf(Expect::string())->min(2)->max(2)
				)
 			]),
			// Views
			'view' => Expect::structure([
				'path' => Expect::string()->required(),
				'ext' => Expect::string()->default('twig'),
				'setting' => Expect::structure([
					// Folder Path Cache
					'cache' => Expect::anyOf(
						Expect::bool(),
						Expect::string()
					)->default(false),
					'debug' => Expect::bool()->default(false),
					'charset ' => Expect::string()->default('utf-8')
				])
			])
		];
	}

	/**
	 * Carga archivos de configuración
	 * @access protected
	 * @param  string $filePath Ruta de archivo
	 * @return void
	 */
	protected function load(string $filePath): void
	{
		$extension = pathinfo($filePath, PATHINFO_EXTENSION);
		if ($extension == 'php') {
			$data = require($filePath);
		} else if($extension == 'ini') {
			$data = parse_ini_file($filePath, true);
		} else {
			throw new UnsupportedExecption("Unsupported file extension: $extension");
		}
		
		$this->setting = new Configuration($this->defaultScheme());
		$this->setting->merge($data);
	}
	/**
	 * Retorna todas las configuraciones de sistema
	 *
	 * @return  Configuration
	 */
	public function get_settings(): Configuration
	{
		return $this->setting;
	}
	/**
	 * Obtiene una configguración por su clave.
	 * @param  string $key     Clave a buscar
	 * @param  mixed $default valor por defecto a devolver
	 * @return mixed
	 */
	public function get(string $key, $default = null) 
	{
		return $this->setting->get($key) ?? $default;
	}

	public function __call(string $name, array $argumentse) {
		if ( !method_exists($this->setting, $name) ) {
			return call_user_func_array([$this->setting, $name], $argumentse);
		}
		return null;
	}

	public function __set(string $key, $value) {
		$this->setting->set($key, $value);
	}

	public function __get(string $key) 
	{
		return $this->setting->get($key);
	}
}