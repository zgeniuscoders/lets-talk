<?php


namespace Zgeniuscoders\Zgeniuscoders\Middlewares;


use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TrailingSlashMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
         $uri = $request->getUri()->getPath();
         if (!empty($uri) && $uri[-1] === "/") {
             return (new Response())
                 ->withStatus(301)
                 ->withHeader('Location', substr($uri, 0, -1));
         }

         return $handler->handle($request);
    }
}