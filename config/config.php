<?php

use Doctrine\ORM\EntityManager;
use Legacy\Legacy\Auth\AuthInterface;
use Legacy\Legacy\Auth\User;
use Legacy\Legacy\Database\DatabaseAuth;
use Legacy\Legacy\Database\DatabaseFactory;
use Legacy\Legacy\Middlewares\CSRFMiddleware;
use Legacy\Legacy\Render\RenderInterface;
use Legacy\Legacy\Twig\TwigRenderFactory;
use Legacy\Legacy\Router\Router;
use Legacy\Legacy\Session\PhpSession;
use Legacy\Legacy\Session\SessionInterface;

return [

    'ASSET_PATH' => dirname(__DIR__).DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR,
    'APP_PATH' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR,

    'MIDDLEWARES' => [
        \Legacy\Legacy\Auth\Middleware\ForbiddenMiddleware::class,
        \Legacy\Legacy\Auth\Middleware\AuthMiddleware::class,
        \Legacy\Legacy\Middlewares\MethodMiddleware::class,
        \Legacy\Legacy\Middlewares\CSRFMiddleware::class,
        \Legacy\Legacy\Middlewares\RouterMiddleware::class,
        \Legacy\Legacy\Middlewares\DispatcherMiddleware::class,
        \Legacy\Legacy\Middlewares\NotFoundMiddleware::class
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
        \Legacy\Legacy\Twig\AuthTwigExtension::class,
        \Legacy\Legacy\Twig\CSRFExtension::class,
        \Legacy\Legacy\Twig\FlashExtension::class,
        \Legacy\Legacy\Twig\TwigFormExtension::class,
        \Legacy\Legacy\Twig\TwigFunction::class
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
