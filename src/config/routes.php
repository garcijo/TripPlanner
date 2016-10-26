<?php

use Slim\Http\Response;
use Web\Action\HomeAction;
use Web\Action\HomePageAction;
use Web\Action\LoginAction;
use Web\Action\LoginPageAction;
use Web\Action\SignupAction;

$app->get('/home', HomePageAction::class)->setName('home');
$app->post('/home', HomeAction::class)->setName('home');
$app->get('/login', LoginPageAction::class)->setName('login');
$app->post('/login', LoginAction::class)->setName('login');
$app->post('/signin', LoginAction::class)->setName('signin');
$app->post('/signup', SignupAction::class)->setName('signup');

$app->get('/[{name}]', function ($request, Response $response, $args) {
    $response = $response->withRedirect('/login');
    return $response;
});