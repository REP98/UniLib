<?php
declare(strict_types=1);

namespace UniLib\Files;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\ErrorHandler;
use DateTimeZone;
use Monolog\Level;

/**
 * Log
 */
class Log
{
	protected static $logger;
    /**
     * Inicializa el registro de Logs
     *
     * @return  \Monolog\Logger
     */
	public static function init(): Logger
    {
        if (!self::$logger) {
            self::$logger = new Logger('unilib');
            
            // Crear los handlers (manejo de archivos de log)
            $rootPath = dirname(__DIR__, 4).DIRECTORY_SEPARATOR;
			if (defined('ROOT_PATH')) {
				$rootPath = ROOT_PATH;
			}
			$logPath = config('log.filename') ?? $rootPath.'storage'.DIRECTORY_SEPARATOR.'log'.DIRECTORY_SEPARATOR.'unilib.log';

            self::$logger->pushHandler(new StreamHandler($logPath, Level::Debug));
            self::$logger->pushHandler(new FirePHPHandler());

            self::$logger->setTimezone(new DateTimeZone('America/Caracas'));

            // Registrar Monolog para manejar errores y excepciones
            ErrorHandler::register(self::$logger);
        }

        return self::$logger;
    }
    
    public static function Debug(string|\Stringable $message, array $context = [])
    {
    	self::$logger->debug($message, $context);
    }

	public static function Notice(string|\Stringable $message, array $context = [])
    {
    	self::$logger->notice($message, $context);
    }

	public static function Info(string|\Stringable $message, array $context = [])
    {
        self::init()->info($message, $context);
    }

    public static function Warning(string|\Stringable $message, array $context = [])
    {
        self::init()->warning($message, $context);
    }

    public static function Error(string|\Stringable $message, array $context = [])
    {
        self::init()->error($message, $context);
    }

    public static function Critical(string|\Stringable $message, array $context = [])
    {
        self::init()->critical($message, $context);
    }

    public static function Alert(string|\Stringable $message, array $context = [])
    {
        self::init()->alert($message, $context);
    }

    public static function Emergency(string|\Stringable $message, array $context = [])
    {
        self::init()->emergency($message, $context);
    }
    
}
