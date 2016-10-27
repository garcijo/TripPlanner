<?php

namespace Web\Action;


use Slim\Http\Request;
use Slim\Http\Response;
use Slim\PDO\Database;
use Web\Domain\ItemsMapper;
use Web\Domain\SessionStorage;

class NewItemAction
{
    protected $db;
    protected $session;

    public function __construct(Database $db, SessionStorage $session)
    {
        $this->db = $db;
        $this->session = $session;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $name = $request->getParsedBodyParam('name');
        $description = $request->getParsedBodyParam('description');
        $check = $request->getParsedBodyParam('tobuy') ?? 0;
        $price = $request->getParsedBodyParam('price');

        $itemsMapper = new ItemsMapper($this->db);
        $newItem = $itemsMapper->createItem($name, $description, $this->session->get('user'), $check, $price);

        $response = $response->withRedirect('/home');

        return $response;
    }
}