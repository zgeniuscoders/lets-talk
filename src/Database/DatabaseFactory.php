<?php


namespace Zgeniuscoders\Zgeniuscoders\Database;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

class DatabaseFactory
{
    /**
     * @param ContainerInterface $container
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
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
            'driver' => 'pdo_mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'user' => 'root',
            'password' => '',
            'dbname' => 'lets-talk'
        );

        // obtaining the entity manager
        return EntityManager::create($connexion, $config);
    }
}