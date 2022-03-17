<?php

$builder = new \DI\ContainerBuilder();
$builder->useAutowiring(true);
$builder->addDefinitions(dirname(__DIR__) . DIRECTORY_SEPARATOR. 'bootstrap/config.php');
$container = $builder->build();

require "../web.php";