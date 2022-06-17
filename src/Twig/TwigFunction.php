<?php

namespace Legacy\Legacy\Twig;

use Psr\Container\ContainerInterface;
use Twig\Extension\AbstractExtension;

class TwigFunction extends AbstractExtension
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
          new \Twig\TwigFunction('asset', [$this, 'getAsset']),
            new \Twig\TwigFunction('storage', [$this, 'storage'])
        ];
    }

    /**
     * @param string $path
     * @return string
     */
    public function getAsset(string $path): string
    {
        return DIRECTORY_SEPARATOR . $path;
    }

    public function storage(string $path)
    {
        return DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $path;
    }
}
