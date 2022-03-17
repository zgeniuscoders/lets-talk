<?php


use Zgeniuscoders\Zgeniuscoders\Database\DBConnection;
use Zgeniuscoders\Zgeniuscoders\Render\RenderInterface;
use Zgeniuscoders\Zgeniuscoders\Render\TwigRenderFactory;
use Zgeniuscoders\Zgeniuscoders\Router\Router;

return [
    'VIEWS_PATH' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR,
    Router::class => DI\create(),
    RenderInterface::class => DI\factory(TwigRenderFactory::class)
];