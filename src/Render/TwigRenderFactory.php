<?php


namespace Zgeniuscoders\Zgeniuscoders\Render;

use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Zgeniuscoders\Zgeniuscoders\Helpers\TwigFormExtension;
use Zgeniuscoders\Zgeniuscoders\Helpers\TwigFunction;
use Zgeniuscoders\Zgeniuscoders\Router\RouterTwigExtension;

class TwigRenderFactory{

    public function __invoke(ContainerInterface $container): TwigRender
    {
        $path = $container->get('VIEWS_PATH');

        $loader = new FilesystemLoader($path);
        $twig = new Environment($loader);
        $twig->addExtension($container->get(TwigFunction::class));
        $twig->addExtension($container->get(TwigFormExtension::class));
        $twig->addExtension($container->get(RouterTwigExtension::class));

        return new TwigRender($loader,$twig);
    }
}