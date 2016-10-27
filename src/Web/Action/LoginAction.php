<?php

namespace Web\Action;

use Slim\PDO\Database;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Web\Domain\SessionStorage;
use Web\Domain\UserMapper;

class LoginAction
{
    protected $view;
    protected $db;
    protected $session;

    public function __construct(Twig $view, Database $db, SessionStorage $session)
    {
        $this->view = $view;
        $this->db = $db;
        $this->session = $session;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $errors = $this->validateSignUp($request->getParsedBody());

        $data = $request->getParsedBody();

        if (empty($errors)) {
            $userName = filter_var($data['username'], FILTER_SANITIZE_STRING);
            $userPass = filter_var($data['password'], FILTER_SANITIZE_STRING);

            $userMapper = new UserMapper($this->db);
            $user = $userMapper->loginUser($userName, $userPass);
            $name = $user->getName();

            $this->session->set('user', $name);
            $data['name'] = $name;
            return $this->view->render($response, 'home.html', $data);
        } else {
            return $this->view->render($response, 'login.html', $data);
        }

    }

    protected function validateSignUp($data)
    {
        $errors = [];
        if (!$data['username']) {
            $errors['username'] = 'Username is required';
        }
        if (!$data['password']) {
            $errors['password'] = 'Password is required';
        }

        return $errors;
    }
}