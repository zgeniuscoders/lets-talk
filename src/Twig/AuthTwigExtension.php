<?php


namespace Legacy\Legacy\Twig;

use Twig\Extension\AbstractExtension;
use Legacy\Legacy\Auth\AuthInterface;
use Legacy\Legacy\Auth\User;

class AuthTwigExtension extends AbstractExtension
{
    public function __construct(private AuthInterface $auth)
    {
    }

    /**
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new \Twig\TwigFunction('auth', [$this, 'auth'])
        ];
    }

    /**
     * @return User|null
     */
    public function auth(): ?User
    {
        return $this->auth->getUser();
    }
}
