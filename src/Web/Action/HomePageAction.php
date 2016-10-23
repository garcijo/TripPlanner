<?php

namespace Web\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class HomePageAction
{
    protected $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $data = ['title' => 'Home'];

        return $this->view->render($response, 'home.html', $data);
    }
}