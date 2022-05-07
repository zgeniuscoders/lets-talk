<?php

namespace Zgeniuscoders\Zgeniuscoders\Database;

use App\Models\User as UserModel;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use GuzzleHttp\Psr7\ServerRequest;
use Zgeniuscoders\Zgeniuscoders\Auth\AuthInterface;
use Zgeniuscoders\Zgeniuscoders\Auth\User;
use Zgeniuscoders\Zgeniuscoders\Facades\Upload;
use Zgeniuscoders\Zgeniuscoders\Helpers\Hash;
use Zgeniuscoders\Zgeniuscoders\Session\SessionInterface;

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
     * @param string $email
     * @param string $password
     * @return null|User
     */
    public function login(string $email, string $password): ?User
    {

        if (empty($email) && empty($password)) {
            return null;
        }

        $user = $this->em->getRepository(UserModel::class)->findOneByEmail($email);

        if ($user && Hash::verify($password, $user->getPassword())) {
            $this->session->set('auth.user', $user->getId());
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
    public function register(ServerRequest $request)
    {
        $params = array_merge($request->getParsedBody(),$request->getUploadedFiles());

        $user = new \App\Models\User;
        $image = Upload::upload($params['profile']);

        $user->setUuid(uniqid())
            ->setName($params["name"])
            ->setEmail($params["email"])
            ->setPseudo($params["pseudo"])
            ->setProfile($image)
            ->setCreated(new \DateTime())
            ->setPassword(Hash::makeHash($params['password']));

        $this->em->persist($user);
        $this->em->flush();

        $this->session->set('auth.user', $user->getId());

        return $user;
    }

    public function logout(): void
    {
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
