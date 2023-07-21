<?php

use Router\Router;
use App\Exceptions\NotFoundException;

require '../vendor/autoload.php'; 

define('VIEWS', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);
define('SCRIPTS', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR);
 
 
define("DB_HOST", "...");
define("DB_USER", "...");
define("DB_PWD", "...");
define("DB_NAME", "...");

$router = new Router($_GET['url']);
 


$router->get('/', 'App\Controllers\ProductsController@welcome');
$router->get('/products', 'App\Controllers\ProductsController@index');
$router->post('/products/create', 'App\Controllers\ProductsController@create');
$router->post('/products/delete', 'App\Controllers\ProductsController@delete');


try {
    $router->run();
} catch (NotFoundException $e) {
    return $e->error404();
}
