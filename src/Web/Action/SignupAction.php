<?php

namespace Web\Action;

use Slim\PDO\Database;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Web\Domain\SessionStorage;
use Web\Domain\UserMapper;

class SignupAction
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
            $userPass = password_hash(filter_var($data['password'], FILTER_SANITIZE_STRING), PASSWORD_DEFAULT);
            $name = filter_var($data['name'], FILTER_SANITIZE_STRING);

            // work out the component
            $userMapper = new UserMapper($this->db);
            //First check the email doesn't exist yet
            $user = $userMapper->searchUser($userName);

            if (!empty($user->getName())) {
                $data['error'] = 'That username already exists!';

                return $this->view->render($response, 'login.html', $data);
            } else {
                $user = $userMapper->createUser($userName, $userPass, $name);
                $this->session->set('user', $user);
                $data['name'] = $user;
            }
        }  else {
            $data['error'] = 'Incorrect information!';

            return $this->view->render($response, 'login.html', $data);
        }

        $response = $response->withRedirect('/home');

        return $response;
    }

    protected function validateSignUp($data)
    {
        $errors = [];
        if (!$data['name']) {
            $errors['name'] = 'Name is required';
        }
        if (!$data['username']) {
            $errors['username'] = 'Username is required';
        }
        if (!$data['password']) {
            $errors['password'] = 'Password is required';
        }

        return $errors;
    }
}
