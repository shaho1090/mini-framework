<?php

namespace App\Services;

use App\Attributes\Route;
use App\Container;
use App\Exceptions\ClassNotFoundException;
use App\Exceptions\FileNotFoundException;
use App\Exceptions\RouteNotFoundException;

class Router
{
    private array $controllers = [];
    private array $routes = [];

    /**
     * @throws FileNotFoundException
     */
    public function __construct(private Container $container)
    {
        $this->setController();
    }

    /**
     * @throws \ReflectionException
     */
    public function registerFromAttributes(): void
    {
        foreach ($this->controllers as $controller) {
            $reflectionController = new \ReflectionClass($controller);

            foreach ($reflectionController->getMethods() as $method) {
                $attributes = $method->getAttributes(Route::class,\ReflectionAttribute::IS_INSTANCEOF);

                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();

                    $this->register($route->method, $route->routePath, [$controller, $method->getName()]);
                }
            }
        }
    }

    public function register(string $requestMethod, string $route, array $action): void
    {
        $this->routes[$requestMethod][$route] = $action;
    }

    /**
     * @throws RouteNotFoundException
     * @throws ClassNotFoundException
     */
    public function resolve(string $requestUri, string $requestMethod)
    {
        $route = explode('?', $requestUri)[0];

        $action = $this->routes[$requestMethod][$route] ?? null;

        if (!$action) {
            throw new RouteNotFoundException();
        }

        if (is_array($action)) {
            [$class, $method] = $action;

            if (class_exists($class)) {
//                $class = new $class();
//                $class = (new Container())->get($class);
                $class = $this->container->get($class);

                if (method_exists($class, $method)) {
                    return call_user_func_array([$class, $method], []);
                }
            }
        }

        throw new RouteNotFoundException();
    }

    /**
     * @throws FileNotFoundException
     */
    private function setController(): void
    {
        if (!file_exists(__DIR__ . '/../controllers.php')) {
            throw new FileNotFoundException();
        };

        $this->controllers = include(__DIR__ . '/../controllers.php');
    }
}