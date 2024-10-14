<?php
declare(strict_types=1);

use UniLib\Router\Middlewares\CsrfVerifier;
use UniLib\Router\Views\ErrorPage;

$debug = (bool)env('DEBUG_MODE', false);
return [
	// Información de Root
	'root' => [
		'path' => ROOT_PATH
	],
	'log' => [
		'filename' => ROOT_PATH.'storage'.DS.'log'.DS.'unilib.log'
	],
	// Router
	'route' => [
		"namespace" => null,
		'csrfVerifier' => new CsrfVerifier(),
		"errview" => [
			'unauthorized' => [ErrorPage::class, 'unauthorized'],
			'forbidden' => [ErrorPage::class, 'forbidden'],
			'notFound' => [ErrorPage::class, 'notFound'],
			'methodNotAllowed' => [ErrorPage::class, 'methodNotAllowed']
		]
	],
	// Views
	'view' => [
		'path' => ROOT_PATH.'views',
		'ext' => 'twig',
		'setting' => [
			// Folder Path Cache
			'cache' => $debug ? false : ROOT_PATH.'storage'.DS.'cache'.DS,
			'debug' => $debug,
			'charset ' => 'utf-8'
		]
	]
];