<?php
declare(strict_types=1);

namespace UniLib\Files;

use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\UnixVisibility\PortableVisibilityConverter;
use UniLib\Exceptions\ClassNotFound;
use Exception;

/**
 * Adapter
 */
class Adapter
{
	public static function local(string $rootPath = null, $visibility = null) : LocalFilesystemAdapter
	{
		if (empty($rootPath)) {
			if (defined('ROOT_PATH')) {
				$rootPath = ROOT_PATH;
			} elseif (function_exists('config') && config('root.path', false)) {
				$rootPath = config('root.path');
			} else {
				throw new Exception("Root Path not defined");
			}
		}

		return !empty($visibility) ?
			new LocalFilesystemAdapter($rootPath, $visibility) :
			new LocalFilesystemAdapter($rootPath);
	}

	public static function visibility(array $file, array $dirname)
	{
		return PortableVisibilityConverter::fromArray([
			'file' => array_merge(['public' => 0640, 'private' => 0604], $file),
			'dir' => array_merge(['public' => 0740, 'private' => 7604], $dirname)
		]);
	}
	/**
	 * @SuppressWarnings(PHPMD.MissingImport)
	 */
	public static function FTP(array $settings) {
		if (!class_exists('FtpAdapter')) {
			throw new ClassNotFound("Adapter not found");
		}

		return new \League\Flysystem\Ftp\FtpAdapter(
			\League\Flysystem\Ftp\FtpConnectionOptions::fromArray($settings)
		);
	}
}