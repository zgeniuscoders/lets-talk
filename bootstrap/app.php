<?php

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

$whoops = new Run();
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

$builder = new \DI\ContainerBuilder();
$builder->useAutowiring(true);
$builder->addDefinitions(dirname(__DIR__) . DIRECTORY_SEPARATOR. 'bootstrap/config.php');
$container = $builder->build();
