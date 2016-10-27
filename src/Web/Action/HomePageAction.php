<?php

namespace Web\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\PDO\Database;
use Slim\Views\Twig;
use Web\Domain\ItemsMapper;
use Web\Domain\SessionStorage;

class HomePageAction
{
    protected $view;
    protected $session;

    public function __construct(Twig $view, Database $db, SessionStorage $session)
    {
        $this->view = $view;
        $this->db = $db;
        $this->session = $session;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $username = $this->session->get('user');

        $data['title'] =  'Home';
        $data['name'] = $username;

        $itemsMapper = new ItemsMapper($this->db);
        $userItems = $itemsMapper->getAllItems($username);
        $data['items'] = $userItems;


        return $this->view->render($response, 'home.html', $data);
    }
}