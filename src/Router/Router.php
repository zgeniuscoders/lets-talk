<?php

namespace Zgeniuscoders\Zgeniuscoders\Router;

use Router\BaseRouter\Route as BaseRoute;
use Router\QuickRouter;
use Psr\Http\Message\ServerRequestInterface;

class Router
{
    private QuickRouter $router;

    public function __construct()
    {
        $this->router = new QuickRouter();
    }

    /**
     * @param string $path
     * @param string $name
     * @param callable $callable
     * @param array $method
     */
    private function addRoute(string $path, string $name, callable $callable, array $method)
    {
        $this->router->addRoute(new BaseRoute($path, $callable, $method, $name));
    }

    /**
     * @param string $path
     * @param callable $callable
     * @param string $name
     */
    public function get(string $path, callable $callable, string $name)
    {
        $this->addRoute($path, $name, $callable, ['GET']);
    }

    /**
     * @param string $path
     * @param callable $callable
     * @param string $name
     */
    public function post(string $path, callable $callable, string $name)
    {
        $this->addRoute($path, $name, $callable, ['POST']);
    }

    /**
     * @param string $path
     * @param callable $callable
     * @param string $name
     */
    public function delete(string $path, callable $callable, string $name)
    {
        $this->addRoute($path, $name, $callable, ['DELETE']);
    }

    /**
     * @param string $path
     * @param callable $callable
     * @param string $name
     */
    public function put(string $path, callable $callable, string $name)
    {
        $this->addRoute($path, $name, $callable, ['PUT']);
    }

    /**
     * @param string $name
     * @param array $params
     * @return string|null
     */
    public function getUri(string $name, array $params = []): ?string
    {
        return $this->router->generateUri($name, $params);
    }

    /**
     * @param ServerRequestInterface $request
     * @return Route|null
     */
    public function matches(ServerRequestInterface $request): ?Route
    {
        $route = $this->router->match($request);
        if ($route->isSuccess()) {
            return new Route(
                name: $route->getMatchedRouteName(),
                callable: $route->getMatchedMiddleware(),
                params: $route->getMatchedParams()
            );
        }
        return null;
    }
}
