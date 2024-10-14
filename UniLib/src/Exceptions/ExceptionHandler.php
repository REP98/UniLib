<?php
declare(strict_types=1);

namespace UniLib\Exceptions;

use Pecee\Http\Request;
use Pecee\SimpleRouter\Handlers\IExceptionHandler;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use UniLib\Exceptions\UnauthorizedException;
use UniLib\Exceptions\ForbiddenException;

/**
 * ExceptionHandler 
 */
class ExceptionHandler implements IExceptionHandler
{
	
	public function handleError(Request $request, \Exception $error): void
	{

		/* You can use the exception handler to format errors depending on the request and type. */

		if ($request->getUrl()->contains('/api')) {

			response()->json([
				'error' => $error->getMessage(),
				'code'  => $error->getCode(),
			]);

		}

		if($error instanceof UnauthorizedException) {
			// Render custom 401-page
			$request->setRewriteCallback(config('route.errview.unauthorized'));
			return;
		}

		if($error instanceof ForbiddenException) {
			// Render custom 403-page
			$request->setRewriteCallback(config('route.errview.forbidden'));
			return;
		}

		/* The router will throw the NotFoundHttpException on 404 */
		if($error instanceof NotFoundHttpException) {

			// Render custom 404-page
			$request->setRewriteCallback(config('route.errview.notFound'));
			return;
			
		}
		
		if($error instanceof MethodNotAllowedException) {
			// Render custom 405-page
			$request->setRewriteCallback(config('route.errview.methodNotAllowed'));
			return;
		}

		throw $error;

	}

}