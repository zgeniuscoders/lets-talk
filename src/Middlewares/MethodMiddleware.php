<?php


namespace Legacy\Legacy\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MethodMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $parsebody = $request->getParsedBody();
        if (array_key_exists('_method', $parsebody) && in_array($parsebody['_method'], ['DELETE','PUT'])) {
            $request = $request->withMethod($parsebody['_method']);
        }

        return $handler->handle($request);
    }
}
