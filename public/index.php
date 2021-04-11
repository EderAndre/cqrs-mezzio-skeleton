<?php

// Delegate static file requests back to the PHP built-in webserver
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}
chdir(dirname(__DIR__));
require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager;
/** @var \Interop\Container\ContainerInterface $container */
$container = require 'config/container.php';
$capsule = new Manager();
$capsule->addConnection($container->get('config')['eloquent']);
$capsule->setAsGlobal();
$capsule->bootEloquent();
/** set display errors in dev or homolog environment */
$label;

if(in_array($_ENV['APP_ENV'],['Development','Homologation'])){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
	set_time_limit(300);
    error_reporting(E_ALL);
    $label=$_ENV['APP_ENV'];
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: x-api-client, x-api-key, x-app-id, x-user-token, Content-Type, Current-Url");
}
/**
 * Self-called anonymous function that creates its own scope and keep the global namespace clean.
 */
(function () {
    /** @var \Psr\Container\ContainerInterface $container */
    $container = require 'config/container.php';

    /** @var \Zend\Expressive\Application $app */
    $app = $container->get(\Zend\Expressive\Application::class);
    $factory = $container->get(\Zend\Expressive\MiddlewareFactory::class);

    // Execute programmatic/declarative middleware pipeline and routing
    // configuration statements
    (require 'config/pipeline.php')($app, $factory, $container);
    (require 'config/routes.php')($app, $factory, $container);

    $app->run();
})();
