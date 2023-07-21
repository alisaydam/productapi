<?php

namespace Router;

use App\Exceptions\NotFoundException;

class Router {

    public $url;
    public $routes = [];

    public function __construct($url)
    {
        $this->cors();
        $this->url = trim($url, '/');
    }

    public function get(string $path, string $action)
    {
         $this->routes['GET'][] = new Route($path, $action);
    }

    public function post(string $path, string $action)
    {
       
        $this->routes['POST'][] = new Route($path, $action);
    }

    public function run()
    {
         foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->matches($this->url)) {
                return $route->execute();
            }
        }

        throw new NotFoundException("Page not found");
    }

    function cors() {
     
        if (isset($_SERVER['HTTP_ORIGIN'])) { 
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    
        }
         
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) 
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); 
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        
            exit(0);
        } 
    }
}
