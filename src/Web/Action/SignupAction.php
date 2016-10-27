<?php

namespace Web\Action;

use Slim\PDO\Database;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Web\Domain\UserMapper;

class SignupAction
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
        $data = $request->getParsedBody();
        $userName = filter_var($data['username'], FILTER_SANITIZE_STRING);
        $userPass = password_hash(filter_var($data['password'], FILTER_SANITIZE_STRING), PASSWORD_DEFAULT);
        $name = filter_var($data['name'], FILTER_SANITIZE_STRING);
        // work out the component
        $userMapper = new UserMapper($this->db);
        //First check the email doesn't exist yet
        $user = $userMapper->searchUser($userName);

        if (!empty($user->getName())) {
            $_POST['error'] = '<p class="error">That username already exists!</p>';

            return $this->view->render($response, 'login.html', $args);
        } else {
            $user = $userMapper->createUser($userName, $userPass, $name);
            $_SESSION['user'] = $userName;
            $response = $response->withRedirect('/home');

            return $response;
        }
    }
}
