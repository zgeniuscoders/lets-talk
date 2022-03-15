<?php

use App\Controllers\MainController;
use Zgeniuscoders\Zgeniuscoders\Router\Exceptions\RouterException;
use Zgeniuscoders\Zgeniuscoders\Router\Router;

require "../vendor/autoload.php";


    $router = new Router();
    $router->get('/',[MainController::class,'index'],'home');


    try{
        $router->run();
    }catch (RouterException $e){
        return $e->error404();
    }