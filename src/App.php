<?php

namespace App;

use App\Exceptions\FileNotFoundException;
use App\Exceptions\RouteNotFoundException;
use App\Services\HelperLoader;
use App\Services\Router;

class App
{
    private static App $instance;
    private Router $router;
    private Container $container;

    private function __construct()
    {
        $this->container = new Container();
    }

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
        $this->runConsole();

        $this->registerRouters();

        echo $this->router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));
    }

    public function runConsole(): void
    {
        new HelperLoader();
    }

    /**
     * @throws \ReflectionException
     * @throws FileNotFoundException
     */
    private function registerRouters(): void
    {
        $this->router = new Router($this->container);
        $this->router->registerFromAttributes();
    }
}