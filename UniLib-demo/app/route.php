<?php
use UniLib\Router\Route;
use UniLibDemo\Controllers\IceCreamController;

Route::get('/', [IceCreamController::class, 'index']);