<?php
declare(strict_types=1);

namespace UniLib\Files;

use UniLib\Traits\DiskFileSystem;
use League\Flysystem\DirectoryListing;

/**
 * File
 */
class File
{
	use DiskFileSystem;

	public function write(string $path, $contents): self 
	{
        $this->filesystem->write($path, $contents, $this->config ?? []);
        return $this;
    }

    public function read(string $path) {
        return $this->filesystem->read($path);
    }

    public function delete(string $path): self
    {
        $this->filesystem->delete($path);
        return $this;
    }

    public function copy($source, $destination): self
    {
        $this->filesystem->copy($source, $destination);
        return $this;
    }

    public function move($source, $destination): self
    {
        $this->filesystem->move($source, $destination);
        return $this;
    }	

    public function contents(string $path, bool $recursive = true, bool $toArray = false): DirectoryListing|array
    {
    	if ($toArray) {
    		$listing  = $this->filesystem->listContents($path, $recursive);
    		$files = ['file' => [], 'dir' => []];
    		/** @var \League\Flysystem\StorageAttributes $item */
		    foreach ($listing as $item) {
		        $path = $item->path();

		        if ($item instanceof \League\Flysystem\FileAttributes) {
		            $files['file'][] = $item;
		        } elseif ($item instanceof \League\Flysystem\DirectoryAttributes) {
		            $files['dir'][] = $item;
		        }
		    }
    		return $files;
    	}
    	return $this->filesystem->listContents($path, $recursive);
    }

    public function exists(string $path): bool
    {
    	return $this->filesystem->fileExists($path);
    }

    public function has(string $path): bool
    {
    	return $this->filesystem->has($path);
    }
}