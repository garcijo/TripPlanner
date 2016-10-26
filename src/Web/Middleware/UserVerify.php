<?php

namespace Web\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class UserVerify
{

    public function __invoke(Request $request, Response $response, $next)
    {
        $route = $request->getAttribute('route');
        $name = $route->getName();

        if (!isset($_SESSION['user']) && !in_array($name, ['login', 'signin', 'signup', 'logout', ''])) {
            $response = $response->withRedirect('/login');

            return $response;
        } elseif (isset($_SESSION['user']) && in_array($name, ['login', 'signin', 'signup', ''])) {
            $response = $response->withRedirect('/home');

            return $response;
        }

        return $next($request, $response);
    }
}