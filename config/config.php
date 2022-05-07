<?php

use Doctrine\ORM\EntityManager;
use Zgeniuscoders\Zgeniuscoders\Auth\AuthInterface;
use Zgeniuscoders\Zgeniuscoders\Auth\User;
use Zgeniuscoders\Zgeniuscoders\Database\DatabaseAuth;
use Zgeniuscoders\Zgeniuscoders\Database\DatabaseFactory;
use Zgeniuscoders\Zgeniuscoders\Middlewares\CSRFMiddleware;
use Zgeniuscoders\Zgeniuscoders\Render\RenderInterface;
use Zgeniuscoders\Zgeniuscoders\Twig\TwigRenderFactory;
use Zgeniuscoders\Zgeniuscoders\Router\Router;
use Zgeniuscoders\Zgeniuscoders\Session\PhpSession;
use Zgeniuscoders\Zgeniuscoders\Session\SessionInterface;

return [

    'ASSET_PATH' => dirname(__DIR__).DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR,
    'APP_PATH' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR,

    'MIDDLEWARES' => [
        \Zgeniuscoders\Zgeniuscoders\Auth\Middleware\ForbiddenMiddleware::class,
        \Zgeniuscoders\Zgeniuscoders\Auth\Middleware\AuthMiddleware::class,
        \Zgeniuscoders\Zgeniuscoders\Middlewares\MethodMiddleware::class,
        \Zgeniuscoders\Zgeniuscoders\Middlewares\CSRFMiddleware::class,
        \Zgeniuscoders\Zgeniuscoders\Middlewares\RouterMiddleware::class,
        \Zgeniuscoders\Zgeniuscoders\Middlewares\DispatcherMiddleware::class,
        \Zgeniuscoders\Zgeniuscoders\Middlewares\NotFoundMiddleware::class
    ],

    'CONTROLLERS' => [
        \App\Controllers\UserController::class,
        \App\Action\User\LoginUser::class,
        \App\Action\User\CreateNewUser::class,
        \App\Action\User\Logout::class,
        \App\Controllers\MessageController::class,
        \App\Controllers\MainController::class
    ],

    'TWIG.EXTENSION' => [
        \Zgeniuscoders\Zgeniuscoders\Twig\AuthTwigExtension::class,
        \Zgeniuscoders\Zgeniuscoders\Twig\CSRFExtension::class,
        \Zgeniuscoders\Zgeniuscoders\Twig\FlashExtension::class,
        \Zgeniuscoders\Zgeniuscoders\Twig\TwigFormExtension::class,
        \Zgeniuscoders\Zgeniuscoders\Twig\TwigFunction::class
    ],

    Router::class => DI\create(),
    RenderInterface::class => DI\factory(TwigRenderFactory::class),
    EntityManager::class => DI\factory(DatabaseFactory::class),
    User::class => DI\factory(function (AuthInterface $auth) {
        return $auth->getUser();
    })->parameter('auth',\DI\get(AuthInterface::class)),
    AuthInterface::class => \DI\get(DatabaseAuth::class),
    SessionInterface::class => DI\create(PhpSession::class),
    CSRFMiddleware::class => DI\create()->constructor(\DI\get(SessionInterface::class))
];
