<?php


namespace App\Controllers;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use Legacy\Legacy\Auth\AuthInterface;
use Legacy\Legacy\Auth\User;
use Legacy\Legacy\Render\RenderInterface;
use Legacy\Legacy\Router\Router;
use Legacy\Legacy\Router\RouterAware;

class Controller
{
    use RouterAware;

    public function __construct(
        protected Router $router,
        protected RenderInterface $render,
        protected EntityManager $em,
        protected AuthInterface $auth
    )
    {
    }

    public function getRepository($entityName): EntityRepository|ObjectRepository
    {
        return $this->em->getRepository($entityName);
    }

    public function auth(): ?User
    {
        return $this->auth->getUser();
    }
}