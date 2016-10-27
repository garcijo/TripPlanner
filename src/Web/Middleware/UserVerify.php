<?php

namespace Web\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;
use Web\Domain\SessionStorage;

class UserVerify
{
    protected $session;

    public function __construct(SessionStorage $session)
    {
        $this->session = $session;
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        $route = $request->getAttribute('route');
        $name = $route->getName();

        if ($this->session->has('user') == false && !in_array($name, ['login', 'signin', 'signup', 'logout', ''])) {
            $response = $response->withRedirect('/login');

            return $response;
        }

        return $next($request, $response);
    }
}