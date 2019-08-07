<?php
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ['app\controllers\Home', 'index']);
    $r->addRoute('GET', '/about', ['app\controllers\Home', 'about']);
    $r->addRoute('GET', '/signup', ['app\controllers\Home', 'signup']);
    $r->addRoute('POST', '/signup', ['app\controllers\Home', 'signup']);
    $r->addRoute('GET', '/verify', ['app\controllers\Home', 'verifyEmail']);
    $r->addRoute('GET', '/login', ['app\controllers\Home', 'login']);
    $r->addRoute('POST', '/login', ['app\controllers\Home', 'login']);
    $r->addRoute('GET', '/logout', ['app\controllers\Home', 'logout']);
    $r->addRoute('GET', '/role', ['app\controllers\Home', 'assignRoleById']);
    // {id} must be a number (\d+)
    $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
    // The /{title} suffix is optional
    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
//        $handler = $routeInfo[1];
//        $vars = $routeInfo[2];
//        $controller = new $handler[0];
//        call_user_func([$controller, $handler[1]], $vars);
        $container->call($routeInfo[1], $routeInfo[2]);
        // ... call $handler with $vars
        break;
}
