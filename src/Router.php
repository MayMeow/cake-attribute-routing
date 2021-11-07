<?php

namespace MayMeow\Routing;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use MayMeow\Routing\Attributes\Route;

class Router
{
    private static string $key = 'Attribute.Routes';

    private static string $cacheConfig = '_cake_routes_';

    /**
     * @var array<Route> $routes
     */
    protected array $routes = [];

    public function __construct()
    {
        foreach (Configure::read('Controllers') as $controller) {
            $reflectedClass = new \ReflectionClass($controller);

            foreach ($reflectedClass->getMethods() as $method) {
                $routeAttribute = $method->getAttributes(Route::class);

                if (!empty($routeAttribute)) {
                    /** @var Route $routeAttributeName */
                    $routeAttributeName = $routeAttribute[0]->newInstance();
                    $routeAttributeName->setAction($this->getActionName($reflectedClass->getName(), $method->getName()));

                    $this->addRoute($routeAttributeName);
                }
            }

        }

    }

    /**
     * @return array<Route>
     */
    public function getRoutes(): array
    {
        $routes = Cache::read(static::$key, static::$cacheConfig);

        if ($routes != false) {
            return $routes;
        }

        Cache::write(static::$key, $this->routes, static::$cacheConfig);

        return $this->routes;
    }

    /**
     * @param Route $route
     */
    public function addRoute(Route $route): void
    {
        array_push($this->routes, $route);

        // sort all routes alphabetically
        sort($this->routes);
    }

    /**
     * @param string $controllerName
     * @param string $methodName
     * @return string
     */
    protected function getActionName(string $controllerName, string $methodName): string
    {
        $controllerParams = explode('\\', $controllerName);

        $controllerName = str_replace('Controller', '', array_pop($controllerParams));

        return "$controllerName::$methodName";
    }
}
