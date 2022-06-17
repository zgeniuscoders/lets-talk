<?php


namespace App\Repositories;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\Mapping\ClassMetadata;

class UserRepository extends EntityRepository
{

    public function getUsers(int $id)
    {

        return $this->createQueryBuilder('u')
            ->where('u.id != :id')
            ->setParameter('id',$id)
            ->orderBy('u.created','DESC')
            ->getQuery()
            ->getResult();
    }
}