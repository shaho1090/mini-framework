<?php

namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Services\Router;

class App
{
    private static App $instance;

    private function __construct(){}

    public static function getInstance(): self
    {
        if(!isset(self::$instance)){
            self::$instance = new self;
        }
        
        return self::$instance;
    }

    /**
     * @throws \ReflectionException|RouteNotFoundException
     */
    public function run(): void
    {
        $router = new Router();
        $router->registerFromAttributes();

        echo $router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));
    }
}