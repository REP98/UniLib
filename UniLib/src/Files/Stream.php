<?php
declare(strict_types=1);

namespace UniLib\Files;

use UniLib\Traits\DiskFileSystem;

/**
 * Stream
 */
class Stream
{
	use DiskFileSystem;

	public function write(string $path, $stream): self 
	{
        $this->filesystem->writeStream($path, $stream, $this->config ?? []);
        return $this;
    }

    public function read(string $path) {
        return $this->filesystem->readStream($path);
    }
}