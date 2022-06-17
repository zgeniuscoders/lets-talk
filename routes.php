<?php


use Legacy\Legacy\Router\Router;
use App\Controllers\MessageController;

$router = new Router();
$router->get('/message/{uuid:[a-z\-0-9]+}',[MessageController::class,'index'],'message.index');