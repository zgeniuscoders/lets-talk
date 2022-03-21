<?php

use App\Request\UserRequest;
use Psr\Container\ContainerInterface;
use Zgeniuscoders\Zgeniuscoders\Database\DBConnection;
use Zgeniuscoders\Zgeniuscoders\Render\RenderInterface;
use Zgeniuscoders\Zgeniuscoders\Render\TwigRenderFactory;
use Zgeniuscoders\Zgeniuscoders\Router\Router;
use Zgeniuscoders\Zgeniuscoders\Router\RouterTwigExtension;

return [
    'db.name' => 'letstalk',
    'db.host' => 'localhost',
    'db.user' => 'root',
    'db.pass' => '',
    'VIEWS_PATH' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR,
    'ASSET_PATH' => DIRECTORY_SEPARATOR,
    Router::class => DI\create(),
    RenderInterface::class => DI\factory(TwigRenderFactory::class),

    DBConnection::class => DI\create()->constructor('localhost','letstalk','root',''),
    UserRequest::class => DI\create()
];
