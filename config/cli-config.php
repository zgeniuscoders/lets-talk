<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require dirname(__DIR__) . DIRECTORY_SEPARATOR  . "bootstrap" . DIRECTORY_SEPARATOR . "app.php";

$entityManager = $container->get(EntityManager::class);

return ConsoleRunner::createHelperSet($entityManager);
