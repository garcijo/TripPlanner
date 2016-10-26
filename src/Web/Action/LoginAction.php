<?php

namespace Web\Action;

use Slim\PDO\Database;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Web\Domain\UserMapper;

class LoginAction
{
    protected $view;
    protected $db;

    public function __construct(Twig $view, Database $db)
    {
        $this->view = $view;
        $this->db = $db;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $errors = $this->validateSignUp($request->getParsedBody());

        $data = [];

        if (empty($errors)) {
            $userName = filter_var($data['email'], FILTER_SANITIZE_STRING);
            $userPass = filter_var($data['password'], FILTER_SANITIZE_STRING);

            $userMapper = new UserMapper($this->db);
            $user = $userMapper->loginUser($userName, $userPass);
            $name = $user->getName();

            $_SESSION['user'] = $name;
            die('marco');
            return $this->view->render($response, 'home.html', $data);
        } else {
            var_dump($errors);
            die('polo');
            return $this->view->render($response, 'login.html', $data);
        }

    }

    protected function validateSignUp($data)
    {
        $errors = [];
        if (!$data['email']) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }
        if (!$data['password']) {
            $errors['password'] = 'Password is required';
        }

        return $errors;
    }
}