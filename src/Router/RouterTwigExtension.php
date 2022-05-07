<?php

namespace Zgeniuscoders\Zgeniuscoders\Router;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RouterTwigExtension extends AbstractExtension
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getFunctions(): array
    {
        return [
          new TwigFunction('path', [$this, 'getPath'])
        ];
    }

    public function getPath(string $path, array $params = []): string
    {
        return $this->router->getUri($path, $params);
    }
}
