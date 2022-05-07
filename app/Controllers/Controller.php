<?php


namespace App\Controllers;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use Zgeniuscoders\Zgeniuscoders\Render\RenderInterface;
use Zgeniuscoders\Zgeniuscoders\Router\Router;
use Zgeniuscoders\Zgeniuscoders\Router\RouterAware;

class Controller
{
    use RouterAware;

    public function __construct(
        protected Router $router,
        protected RenderInterface $render,
        protected EntityManager $em
    )
    {
    }

    public function getRepository($entityName): EntityRepository|ObjectRepository
    {
        return $this->em->getRepository($entityName);
    }
}