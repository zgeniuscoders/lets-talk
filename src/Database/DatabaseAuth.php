<?php

namespace Legacy\Legacy\Database;

use App\Models\User as UserModel;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ObjectRepository;
use GuzzleHttp\Psr7\ServerRequest;
use Legacy\Legacy\Auth\AuthInterface;
use Legacy\Legacy\Auth\User;
use Legacy\Legacy\Facades\Upload;
use Legacy\Legacy\Helpers\Hash;
use Legacy\Legacy\Session\SessionInterface;

class DatabaseAuth implements AuthInterface
{

    /**
     * @var User
     */
    private $user;

    public function __construct(
        private EntityManager $em,
        private SessionInterface $session
    ) {
    }

    /**
     * @param $repository
     * @return EntityRepository|ObjectRepository
     */
    private function getRepository($repository): EntityRepository|ObjectRepository
    {
        return $this->em->getRepository($repository);
    }

    /**
     * @throws ORMException
     */
    private function persist($entity)
    {
        $this->em->persist($entity);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    private function flush()
    {
        $this->em->flush();
    }

    /**
     * @param string $email
     * @param string $password
     * @return null|User
     * @throws ORMException
     */
    public function login(string $email, string $password): ?User
    {

        if (empty($email) && empty($password)) {
            return null;
        }

        $user = $this->em->getRepository(UserModel::class)->findOneByEmail($email);

        if ($user && Hash::verify($password, $user->getPassword())) {
            $this->session->set('auth.user', $user->getId());

            $user->setStatus(1);
            $this->persist($user);
            $this->flush();

            return $user;
        }

        return null;
    }

    /**
     * @param ServerRequest $request
     * @return UserModel
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function register(ServerRequest $request): UserModel
    {
        $params = array_merge($request->getParsedBody(), $request->getUploadedFiles());

        $user = new \App\Models\User;
        $image = Upload::upload($params['profile']);

        $user->setUuid(uniqid())
            ->setName($params["name"])
            ->setEmail($params["email"])
            ->setPseudo($params["pseudo"])
            ->setProfile($image)
            ->setCreated(new \DateTime())
            ->setStatus(1)
            ->setPassword(Hash::makeHash($params['password']));

        $this->em->persist($user);
        $this->em->flush();

        $this->session->set('auth.user', $user->getId());

        return $user;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function logout(string $uuid): void
    {
        $user = $this->getRepository(UserModel::class)->findOneByUuid($uuid);

//        reset the user status
        $user->setStatus(0);

        $this->persist($user);
        $this->flush();

        $this->session->delete('auth.user');
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        if ($this->user) {
            return $this->user;
        }

        $userId = $this->session->get('auth.user');
        if ($userId) {
            try {
                $this->user = $this->em->getRepository(UserModel::class)->find($userId);
                return $this->user;
            } catch (\Exception) {
                $this->session->delete('auth.user');
                return null;
            }
        }

        return null;
    }

}
