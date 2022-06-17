<?php


namespace Legacy\Legacy\Auth;

interface AuthInterface
{
    /**
     * @return User|null
     */
    public function getUser(): ?User;
}
