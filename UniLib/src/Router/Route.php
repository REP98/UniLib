<?php
declare(strict_types=1);

namespace UniLib\Router;

use Pecee\SimpleRouter\SimpleRouter;
use UniLib\Router\Middlewares\csrfVerifier;
use UniLib\Exceptions\ExceptionHandler;
/**
 * Route
 */
class Route extends SimpleRouter
{
	public static function init($fileRouters, array $settings = []): void 
	{

		if (array_key_exists('csrfVerifier', $settings) && !empty($settings['csrfVerifier']) ) {
			parent::csrfVerifier($settings['csrfVerifier']);
		} else {
			parent::csrfVerifier(new csrfVerifier());
		}

       	parent::group(["exceptionHandler" => ExceptionHandler::class], function () use ($fileRouters) {
       		 // change this to whatever makes sense in your project
        	require_once $fileRouters;
       	});

        if (array_key_exists('namespace', $settings) && !empty($settings['namespace'])) {
        	// change default namespace for all routes
        	parent::setDefaultNamespace($settings['namespace']);
        }

        // Do initial stuff
        parent::start();

    }
}