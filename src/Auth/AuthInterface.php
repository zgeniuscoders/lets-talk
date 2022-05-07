<?php


namespace Zgeniuscoders\Zgeniuscoders\Auth;

interface AuthInterface
{
    /**
     * @return User|null
     */
    public function getUser(): ?User;
}
