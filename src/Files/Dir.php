<?php
declare(strict_types=1);

namespace UniLib\Files;

use UniLib\Traits\DiskFileSystem;

/**
 * Dir
 */
class Dir
{
	use DiskFileSystem;
    /**
     * Crea un nuevo Directorio
     * @param  string $path Ruta a crear
     * @return Dir
     */
	public function create(string $path): self
	{
		$this->filesystem->createDirectory($path, $this->config ?? []);
		return $this;
	}
    /**
     * Borrar un Directorio
     * @param  string $path Ruta a borrar
     * @return Dir
     */
	public function delete(string $path): self 
    {
    	$this->filesystem->deleteDirectory($path);
    	return $this;
    }
    /**
     * Verifica si un directorio existe
     * @param  string $path Ruta del Directorio
     * @return bool
     */
    public function exists(string $path): bool
    {
    	return $this->filesystem->directoryExists($path);
    }
}