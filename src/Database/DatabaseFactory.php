<?php


namespace Zgeniuscoders\Zgeniuscoders\Database;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use function DI\get;

class DatabaseFactory
{
    /**
     * @param ContainerInterface $container
     * @return EntityManager
     * @throws ORMException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): EntityManager
    {
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;

        $config = Setup::createAnnotationMetadataConfiguration(
            [$container->get("APP_PATH")],
            $isDevMode,
            $proxyDir,
            $cache,
            $useSimpleAnnotationReader
        );

        // database configuration parameters
        $connexion = array(
            'driver' => "pdo_mysql",
            'host' => "127.0.0.1",
            'port' => "3306",
            'user' => "root",
            'password' => "",
            'dbname' => "lets-talk"
        );

        // obtaining the entity manager
        return EntityManager::create($connexion, $config);
    }
}
