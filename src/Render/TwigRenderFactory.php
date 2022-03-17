<?php


namespace Zgeniuscoders\Zgeniuscoders\Render;

use Psr\Container\ContainerInterface;

class TwigRenderFactory{

    public function __invoke(ContainerInterface $container): TwigRender
    {
        return new TwigRender($container->get('VIEWS_PATH'));
    }
}