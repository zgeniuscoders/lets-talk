<?php


namespace Zgeniuscoders\Zgeniuscoders\Middlewares;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zgeniuscoders\Zgeniuscoders\Render\RenderInterface;

class NotFoundMiddleware implements MiddlewareInterface
{

    public function __construct(private RenderInterface $render)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new Response(status: 404, body: $this->render->render('errors/404'));
    }
}
