<?php


namespace Legacy\Legacy\Middlewares;

use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Legacy\Legacy\Router\Route;

class DispatcherMiddleware implements MiddlewareInterface
{

    /**
     * DispatcherMiddleware constructor.
     * @param ContainerInterface $container
     */
    public function __construct(private ContainerInterface $container)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $route = $request->getAttribute(Route::class);

        if (is_null($route)) {
            return $handler->handle($request);
        }

        $callback = $route->getCallback();

        if (is_string($callback)) {
            $callback = $this->container->get($callback);
        }

        $response = call_user_func_array($route->getCallback(), [$request]);

        if (is_string($response)) {
            return new Response(body: $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception("The response is not a string or an instance of ResponseInterface");
        }
    }
}
