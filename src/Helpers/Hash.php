<?php


namespace Zgeniuscoders\Zgeniuscoders\Helpers;

class Hash
{
    /**
     * @param string $password
     * @return string
     */
    public static function makeHash(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
