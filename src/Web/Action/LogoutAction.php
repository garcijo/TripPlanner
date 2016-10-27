<?php

namespace Web\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Web\Domain\SessionStorage;

class LogoutAction
{
    /**
     * @var Twig
     */
    private $view;
    protected $session;

    public function __construct(Twig $view, SessionStorage $session)
    {
        $this->view = $view;
        $this->session = $session;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $this->session->destroy();

        $response = $response->withRedirect('/login');

        return $response;
    }
}
