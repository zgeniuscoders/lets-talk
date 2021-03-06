<?php

namespace Zgeniuscoders\Zgeniuscoders\Helpers;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

trait RouterAware{

    /**
     * send a response of redirect
     * @param string $path
     * @param array $params
     * @return ResponseInterface
     */
    public function redirect(string $path, array $params = []): ResponseInterface
    {
        $uri = $this->router->getUri($path,$params);
        return (new Response())
            ->withStatus(301)
            ->withHeader('location',$uri);
    }
}