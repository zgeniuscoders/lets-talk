<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions(__DIR__. DIRECTORY_SEPARATOR . 'config.php');
$container = $builder->build();

$entityManager = $container->get(EntityManager::class);

return ConsoleRunner::createHelperSet($entityManager);
