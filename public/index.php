<?php

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__.$url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__.'/../vendor/autoload.php';
session_start();
// Instantiate the app
$app = new \Slim\App();
require __DIR__.'/../src/config/dependencies.php';
require __DIR__.'/../src/config/routes.php';
require __DIR__.'/../src/config/middleware.php';
// Run app
$app->run();
