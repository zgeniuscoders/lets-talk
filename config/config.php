<?php

use Doctrine\ORM\EntityManager;
use Zgeniuscoders\Zgeniuscoders\Database\DatabaseFactory;
use Zgeniuscoders\Zgeniuscoders\Render\RenderInterface;
use Zgeniuscoders\Zgeniuscoders\Twig\TwigRenderFactory;
use Zgeniuscoders\Zgeniuscoders\Router\Router;
use Zgeniuscoders\Zgeniuscoders\Session\PhpSession;
use Zgeniuscoders\Zgeniuscoders\Session\SessionInterface;

return [

    'VIEWS_PATH' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR,
    'ASSET_PATH' => DIRECTORY_SEPARATOR,
    'APP_PATH' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR,

    Router::class => DI\create(),
    RenderInterface::class => DI\factory(TwigRenderFactory::class),
    EntityManager::class => DI\factory(DatabaseFactory::class),
    SessionInterface::class => DI\create(PhpSession::class)
];
