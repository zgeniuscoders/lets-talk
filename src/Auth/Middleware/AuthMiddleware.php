<?php


namespace Zgeniuscoders\Zgeniuscoders\Auth\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zgeniuscoders\Zgeniuscoders\Auth\AuthInterface;
use Zgeniuscoders\Zgeniuscoders\Auth\Exceptions\ForbiddenException;

class AuthMiddleware implements MiddlewareInterface
{

    public function __construct(private AuthInterface $auth)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $user = $this->auth->getUser();

        if ($request->getUri()->getPath() === '/login' || $request->getUri()->getPath() === "/register") {
            return  $handler->handle($request);
        }

        if (is_null($user)) {
            throw new ForbiddenException();
        }

        return  $handler->handle($request->withAttribute('user', $user));
    }
}
