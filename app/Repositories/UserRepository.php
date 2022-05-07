<?php


namespace App\Repositories;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\Mapping\ClassMetadata;

class UserRepository extends EntityRepository
{

    public function getUsers()
    {

        return $this->createQueryBuilder('u')
            ->where('u.id != :id')
            ->setParameter('id',2)
            ->orderBy('u.created','DESC')
            ->getQuery()
            ->getResult();
    }
}