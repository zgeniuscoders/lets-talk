<?php

use Zgeniuscoders\Zgeniuscoders\Module\App;
use App\Controllers\MainController;
use App\Controllers\UserController;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Zgeniuscoders\Zgeniuscoders\Render\RenderInterface;
use Zgeniuscoders\Zgeniuscoders\Router\Router;

use function Http\Response\send;

require "../vendor/autoload.php";
require "../bootstrap/app.php";

$loader = new FilesystemLoader($container->get('VIEWS_PATH'));
$twig = new Environment($loader);

$app = new App($container,
[
    MainController::class,
    UserController::class
]);

$response = $app->run(GuzzleHttp\Psr7\ServerRequest::fromGlobals());
send($response);

