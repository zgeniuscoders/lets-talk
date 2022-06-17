<?php

use App\Action\User\CreateNewUser;
use App\Action\User\LoginUser;
use App\Action\User\Logout;
use App\Controllers\MessageController;
use Legacy\Legacy\App;
use App\Controllers\MainController;
use App\Controllers\UserController;

use function Http\Response\send;

chdir(dirname(__DIR__));

require "vendor/autoload.php";

define('LEGACY_START', microtime(true));

require "bootstrap/app.php";

$app = (new App("config/config.php"))
    ->addController(UserController::class)
    ->addController(MainController::class)
    ->addController(MessageController::class)
    ->addController(CreateNewUser::class)
    ->addController(LoginUser::class)
    ->addController(Logout::class);

if($app->getContainer()->has('MIDDLEWARES'))
{
    foreach ($app->getContainer()->get('MIDDLEWARES') as $middleware)
    {
        $app->addMiddleware($middleware);
    }
}


$response = $app->run(GuzzleHttp\Psr7\ServerRequest::fromGlobals());
send($response);

