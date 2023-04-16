<?php

declare(strict_types=1);

use App\Http\Controllers\TestController;
use App\Http\Request;

$container = require __DIR__ . '/bootstrap.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute(Request::METHOD_GET, '/api/test', [TestController::class, 'test']);
});

$route = $dispatcher->dispatch(Request::method(), Request::uri());

switch ($route[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        break;
    case FastRoute\Dispatcher::FOUND:
        [$controller, $method] = $route[1];

        $vars = $response[2] ?? [];

        try {
            echo $container->call($route[1], $route[2] ?? []);
        } catch (Exception $exception) {
            echo json_encode([
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace(),
            ]);
        }

        break;
}
