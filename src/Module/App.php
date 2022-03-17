<?php


namespace Zgeniuscoders\Zgeniuscoders\Module;

use GuzzleHttp\Psr7\Response;
use Zgeniuscoders\Zgeniuscoders\Router\Router;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param array $controllers
     *
     * @var array
     */
    private array $controllers;

    /**
     * @param ContainerInterface $container
     * @param array $controllers
     */
    public function __construct(ContainerInterface $container, array $controllers)
    {
        $this->container = $container;
        // $this->container->get(RenderInterface::class)->addGlobal("router", $this->container->get(Router::class));

        foreach ($controllers as $controller) {
            $this->controllers[] = $container->get($controller);
        }
    }

    /**
     * run
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && $uri[-1] === "/") {
            return (new Response())
                ->withStatus(301)
                ->withHeader('Location', substr($uri, 0, -1));
        }

        $route = $this->container->get(Router::class)->matches($request);
        if (is_null($route)) {
            return new Response(status: 404, body: '<h1>404</h1>');
        }

        $params = $route->getParams();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);

        $response = call_user_func_array($route->getCallback(), [$request]);
        if (is_string($response)) {
            return new Response(body: $response);
        } elseif ($response instanceof RequestInterface) {
            return $response;
        } else {
            throw new \Exception("The response is not a string or an instance of ResponseInterface");
        }
    }
}
