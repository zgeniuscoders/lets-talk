<?php


namespace Legacy\Legacy\Facades;

use App\Models\User;
use Doctrine\ORM\EntityManager;
use Legacy\Legacy\Database\DatabaseAuth;
use Legacy\Legacy\Session\SessionInterface;

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
