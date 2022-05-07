<?php


namespace Zgeniuscoders\Zgeniuscoders\Twig;

use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Zgeniuscoders\Zgeniuscoders\Render\TwigRender;
use Zgeniuscoders\Zgeniuscoders\Router\RouterTwigExtension;
use function DI\get;

class TwigRenderFactory
{

    public function __invoke(ContainerInterface $container): TwigRender
    {
        $debug = false;
        $cache = false;
        $auto_reload = false;

        if (getenv('APP_ENV') != 'dev') {
            $debug = true;
            $cache = 'temp/views/';
            $auto_reload = true;
        }

        $loader = new FilesystemLoader('views/');
        $twig = new Environment($loader, [
            'debug' => $debug,
            'cache' => $cache,
            'auto_reload' => $auto_reload
        ]);

        $twig->addExtension($container->get(TwigFunction::class));
        $twig->addExtension($container->get(TwigFormExtension::class));
        $twig->addExtension($container->get(RouterTwigExtension::class));
        $twig->addExtension($container->get(FlashExtension::class));
        $twig->addExtension($container->get(CSRFExtension::class));
        $twig->addExtension($container->get(AuthTwigExtension::class));

        return new TwigRender($loader, $twig);
    }
}
