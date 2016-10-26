<?php


use Interop\Container\ContainerInterface;
use Slim\PDO\Database;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Symfony\Component\Yaml\Yaml;
use Web\Action\HomeAction;
use Web\Action\HomePageAction;
use Web\Action\LoginAction;
use Web\Action\LoginPageAction;
use Web\Action\SignupAction;
use Web\Middleware\UserVerify;

$container = $app->getContainer();

$container['config'] = function () {
    $configPath = __DIR__ . '/environment/main.yaml';
    if (!file_exists($configPath)) {
        throw new Exception('Config file main.yaml does not exists.');
    }
    return Yaml::parse(file_get_contents($configPath));
};

foreach ($container->get('config')['settings'] as $key => $value) {
    $container['settings'][$key] = $value;
}

/**
 * @param ContainerInterface $container
 *
 * @return Twig
 */
$container['view'] = function (ContainerInterface $container) {
    $view = new Twig(__DIR__ . '/../Web/views');
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new TwigExtension($container['router'], $basePath));

    return $view;
};

// Database container
$container['db'] = function (ContainerInterface $container) {
    $dbConfig = $container->get('config')['db'];
    $dsn = sprintf('%s:host=%s;dbname=%s;charset=%s', $dbConfig['dbType'], $dbConfig['host'], $dbConfig['dbName'],
        $dbConfig['charset']);
    return new Database($dsn, $dbConfig['username'], $dbConfig['password']);
};


// Home page
$container[HomePageAction::class] = function (ContainerInterface $container) {
    return new HomePageAction(
        $container->get('view')
    );
};
$container[HomeAction::class] = function (ContainerInterface $container) {
    return new HomeAction(
        $container->get('view')
    );
};

// Login page
$container[LoginPageAction::class] = function (ContainerInterface $container) {
    return new LoginPageAction(
        $container->get('view')
    );
};
$container[LoginAction::class] = function (ContainerInterface $container) {
    return new LoginAction(
        $container->get('view'),
        $container->get('db')
    );
};
$container[SignupAction::class] = function (ContainerInterface $container) {
    return new SignupAction(
        $container->get('view'),
        $container->get('db')
    );
};


// MIDDLEWARE
$container['userVerify'] = function () {
    return new UserVerify();
};
