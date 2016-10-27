<?php

namespace Web\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Web\Domain\SessionStorage;

class HomePageAction
{
    protected $view;
    protected $session;

    public function __construct(Twig $view, SessionStorage $session)
    {
        $this->view = $view;
        $this->session = $session;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $data['title'] =  'Home';
        $data['name'] = $this->session->get('user');

        return $this->view->render($response, 'home.html', $data);
    }
}