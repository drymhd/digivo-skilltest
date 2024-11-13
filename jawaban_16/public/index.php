<?php

require __DIR__ . '/../core/Autoloader.php';

use Core\Autoloader;
use Core\Router;

Autoloader::register(); 

$router = new Router();

$router->get('/', 'HomeController@index');

try {
    $router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo $e;
    echo $e->getMessage();
}
