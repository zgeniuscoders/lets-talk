<?php


namespace Zgeniuscoders\Zgeniuscoders\Render;

use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Zgeniuscoders\Zgeniuscoders\Twig\TwigFormExtension;
use Zgeniuscoders\Zgeniuscoders\Twig\TwigFunction;
use Zgeniuscoders\Zgeniuscoders\Router\RouterTwigExtension;
use Zgeniuscoders\Zgeniuscoders\Twig\FlashExtension;

class TwigRenderFactory{

    public function __invoke(ContainerInterface $container): TwigRender
    {
        $path = $container->get('VIEWS_PATH');

        $loader = new FilesystemLoader($path);
        $twig = new Environment($loader);

        $twig->addExtension($container->get(TwigFunction::class));
        $twig->addExtension($container->get(TwigFormExtension::class));
        $twig->addExtension($container->get(RouterTwigExtension::class));
        $twig->addExtension($container->get(FlashExtension::class));

        return new TwigRender($loader,$twig);
    }
}