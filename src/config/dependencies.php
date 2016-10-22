<?php


use Interop\Container\ContainerInterface;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Symfony\Component\Yaml\Yaml;

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
