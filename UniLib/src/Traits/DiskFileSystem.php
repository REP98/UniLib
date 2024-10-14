<?php
declare(strict_types=1);

namespace UniLib\Traits;

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemAdapter;

/**
 * Trait Singleton
 * establece función para evitar el new
 */
trait DiskFileSystem {
	private static $instance = null;
	protected Filesystem $filesystem;

	/**
	 * Incializador
	 * $config = [
	 * 'public_url' => 'https://example.org/assets/',
	 * 'checksum_algo' => 'sha256'
	 * ]
	 * @param FilesystemAdapter $config [description]
	 */
	private function __construct(
		protected FilesystemAdapter $adapter,
		protected array $config = []
	)
	{
		$this->filesystem = new Filesystem($this->adapter);
	}
	/**
	 * Disco de carga
	 * @param  FilesystemAdapter $adapter Adaptador
	 * @return \UniLib\Files\Dir|\UniLib\Files\File|\UniLib\Files\Stream
	 */
	public static function disk(FilesystemAdapter $adapter): self
	{
		if (is_null(self::$instance)) {
			self::$instance = new self($adapter);
		}

		return self::$instance;
	}
	/**
	 * Establece configuraciones adicionales
	 * @param array $config matriz de configuración
	 * @return  \UniLib\Files\Dir|\UniLib\Files\File|\UniLib\Files\Stream
	 */
	public function set_config(array $config): self
	{
		$this->config = array_merge($this->config, $config);
		return $this;
	}

	/**
     * Funciones disponibles
     * lastModified
     * mimeType
     * fileSize
     * visibility
     * publicUrl
     * temporaryUrl
     * checksum
     */
    public function __call($name, $args) {
    	if (method_exists($this->filesystem, $name)) {
    		return $this->filesystem->{$name}(...$args);
    	}
    }
}