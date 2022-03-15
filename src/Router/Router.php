<?php

namespace Zgeniuscoders\Zgeniuscoders\Router;

use Zgeniuscoders\Zgeniuscoders\Router\Exceptions\RouterException;

class Router
{
    private array $routes = [];
    private array $namedRoutes = [];

    /**
     * @param string $path
     * @param callable $callable
     * @param string|null $name
     * @return Router
     */
    public function get(string $path, callable|array $callable, string $name = null): Router
    {
        $this->add(path: $path,callable: $callable,name: $name,method: 'GET');
        return $this;
    }

    /**
     * @param string $path
     * @param callable $callable
     * @param string|null $name
     * @return Router
     */
    public function post(string $path, callable|array $callable, string $name = null): Router
    {
        $this->add(path: $path,callable: $callable,name: $name,method: 'POST');
        return $this;
    }

    /**
     * @param string $path
     * @param callable $callable
     * @param string $name
     * @param string $method
     * @return void
     */
    public function add(string $path, callable|array $callable, string $name, string $method)
    {
        $route = new Route($path, $callable, $name);
        $this->routes[$method][] = $route;
        if (!is_null($name)) {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    public function url(string $name, array $params = null)
    {
        if (!isset($this->namedRoutes[$name])) {
            throw new RouterException("No route matxhed this name");
        }
        $this->namedRoutes[$name]->getUrl($params);
    }

    public function run()
    {
        if (!isset($this->routes[$_SERVER["REQUEST_METHOD"]])) {
            throw new RouterException('The request method doesn\'t exist');
        }

        foreach ($this->routes[$_SERVER["REQUEST_METHOD"]] as $route) {
            if ($route->matches($_GET['url'])) {
                return $route->call();
            }
        }
        throw new RouterException("no matching route 404");
    }
}
