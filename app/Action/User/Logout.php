<?php


namespace App\Action\User;


use App\Controllers\Controller;
use Doctrine\ORM\EntityManager;
use Zgeniuscoders\Zgeniuscoders\Database\DatabaseAuth;
use Zgeniuscoders\Zgeniuscoders\Helpers\Redirect;
use Zgeniuscoders\Zgeniuscoders\Render\RenderInterface;
use Zgeniuscoders\Zgeniuscoders\Router\Router;
use Zgeniuscoders\Zgeniuscoders\Session\Flash;

class Logout extends Controller
{
    /**
     * @var Flash
     */
    private Flash $flash;


    /**
     * @var DatabaseAuth
     */
    private DatabaseAuth $auth;

    public function __construct(Router $router, RenderInterface $render, Flash $flash, DatabaseAuth $auth,EntityManager $em)
    {
        parent::__construct($router, $render,$em);
        $this->router->post('/logout', [$this, 'logout'], 'logout');
        $this->flash = $flash;
        $this->auth = $auth;
    }

    public function logout()
    {
        $this->auth->logout();
        return  new Redirect('/login');
    }
}