<?php


namespace App\Repositories;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\Mapping\ClassMetadata;
use JetBrains\PhpStorm\Pure;

class MessageRepository extends EntityRepository
{
    /**
     * @param int $auth
     * @param int $user
     * @return mixed
     */
    public function getMessages(int $auth, int $user): mixed
    {
        return $this->createQueryBuilder('m')
            ->where("m.sender = :auth AND m.receive = :user")
            ->orWhere("m.sender = :user AND m.receive = :auth")
            ->setParameter('auth', $auth)
            ->setParameter('user', $user)
            ->orderBy("m.id","ASC")
            ->getQuery()
            ->getResult();
    }

    public function getLast(int $auth, int $user)
    {
        return $this->createQueryBuilder('m')
            ->where("m.sender = :auth AND m.receive = :user")
            ->orWhere("m.sender = :user AND m.receive = :auth")
            ->setParameter('auth', $auth)
            ->setParameter('user', $user)
            ->orderBy("m.created","DESC")
            ->getQuery()
            ->getResult();
    }
}