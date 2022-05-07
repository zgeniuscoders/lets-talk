<?php


namespace Zgeniuscoders\Zgeniuscoders\Facades;


use App\Models\User;
use Doctrine\ORM\EntityManager;
use Zgeniuscoders\Zgeniuscoders\Database\DatabaseAuth;
use Zgeniuscoders\Zgeniuscoders\Session\SessionInterface;

class Auth
{


//    private static DatabaseAuth $auth;
//
//    public function __construct(DatabaseAuth $auth)
//    {
//        $this->auth = $auth;
//    }
//
//    public static function __callStatic(string $name, array $arguments)
//    {
//        $auth = new DatabaseAuth();
//        return call_user_func_array([self::$auth,$name], $arguments);
//    }
}