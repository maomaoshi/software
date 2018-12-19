<?php

require __DIR__ . '/vendor/autoload.php';

$settings = require __DIR__ . '/src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/src/dependencies.php';

// Register routes
require __DIR__ . '/src/routes.php';

session_start();

// Run app

$app->run();

/*use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app = new \Slim\App;
$app->post('/', function (ServerRequestInterface $request, ResponseInterface $response) {
    // 使用 PSR 7 $request 对象
	var_dump($request->getParsedBody());
    return $response;
});
$app->run();*/


