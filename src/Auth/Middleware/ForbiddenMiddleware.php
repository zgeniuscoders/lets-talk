<?php

namespace Zgeniuscoders\Zgeniuscoders\Auth;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zgeniuscoders\Zgeniuscoders\Auth\Exceptions\ForbiddenException;
use Zgeniuscoders\Zgeniuscoders\Helpers\Redirect;
use Zgeniuscoders\Zgeniuscoders\Session\Flash;
use Zgeniuscoders\Zgeniuscoders\Session\SessionInterface;

class ForbiddenMiddleware implements MiddlewareInterface
{

    public function __construct(private SessionInterface $session)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (ForbiddenException $exception) {
            return $this->redirect($request);
        }catch (\Exception $error)
        {
            if(str_contains($error->getMessage(), User::class))
            {
                return $this->redirect($request);
            }
        }
    }

    private function redirect(ServerRequestInterface $request)
    {
        (new Flash($this->session))->error('You must have an account before use this page');
        $this->session->set('redirect', $request->getUri()->getPath());
        return new Redirect('/login');
    }
}