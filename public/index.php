<?php

use App\Controllers\MainController;
use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;
use Zgeniuscoders\Zgeniuscoders\Module\App;

use function Http\Response\send;

require "../vendor/autoload.php";
require "../bootstrap/app.php";

$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

$app = new App([
    MainController::class
]);

$response = $app->run(GuzzleHttp\Psr7\ServerRequest::fromGlobals());
send($response);
