<?php


namespace App\Controllers;

use Doctrine\ORM\EntityManager;
use Legacy\Legacy\Auth\AuthInterface;
use Legacy\Legacy\Router\Router;
use Legacy\Legacy\Render\RenderInterface;

class UserController extends Controller
{

    public function __construct(Router $router, RenderInterface $render, EntityManager $em,AuthInterface $auth)
    {
        parent::__construct($router, $render,$em,$auth);
        $this->router->get('/login', [$this, 'login'], 'user.login');
        $this->router->get('/register', [$this, 'register'], 'user.register');
        // $router->get('/mot-de-pass-oublier', [$this, 'forgot'], 'user.forgot');
        $this->router->get('/reset', [$this, 'register'], 'user.reset');
        $this->em = $em;
    }

    /**
     * @return mixed
     */
    public function login()
    {
        return $this->render->render('auth/login');
    }

    /**
     * @return mixed
     */
    public function register()
    {
        return $this->render->render('auth/register');
    }

    /**
     * @return mixed
     */
    public function forget()
    {
        return $this->render->render('auth/forget');
    }

    /**
     * @return mixed
     */
    public function reset()
    {
        return $this->render->render('auth/reset');
    }

}
