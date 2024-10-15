<?php
declare(strict_types=1);

namespace UniLib\Router\Views;
/**
 * ErrorPage
 */
class ErrorPage
{
	public function unauthorized() {
		return "Error: Unauthorized 401";
	}

	public function forbidden() {
		return "Error: Forbidden 403";
	}

	public function notFound() {
		return "Page Not Found (404)";
	}

	public function methodNotAllowed() {
		return "Error: Method not Allowed 405";
	}
}
?>