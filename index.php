<?php

declare(strict_types=1);

use App\Exceptions\Http\UnauthenticatedException;
use App\Exceptions\Http\ValidationException;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\HttpCode;
use App\Http\Request;
use App\Http\Response;

$container = require __DIR__ . '/bootstrap.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute(Request::METHOD_POST, '/api/login', [LoginController::class, 'login']);
    $r->addRoute(Request::METHOD_POST, '/api/register', [RegisterController::class, 'register']);

    // Implement protected route
});

// TODO : Consider wrapping this in some route resolver object
$route = $dispatcher->dispatch(Request::method(), Request::uri());

switch ($route[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo Response::json(['message' => 'Not found'], HttpCode::NOT_FOUND);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        echo Response::json(['message' => 'Method not allowed'], HttpCode::METHOD_NOT_ALLOWED);
        break;
    case FastRoute\Dispatcher::FOUND:
        [$controller, $method] = $route[1];

        $vars = $response[2] ?? [];

        try {
            echo $container->call($route[1], $route[2] ?? []);
        } catch (UnauthenticatedException $exception) {
            echo Response::json([
                'message' => 'Unauthorized'
            ], HttpCode::UNAUTHORIZED);
        } catch (ValidationException $exception) {
            echo Response::json($exception->request->errors(), $exception->request->getHttpErrorCode());
        } catch (Exception $exception) {
            echo Response::json([
                'message' => 'Server error',
                'error' => $exception->getMessage(),
                'trace' => $exception->getTrace()
            ], HttpCode::INTERNAL_ERROR);
        }

        break;
}
