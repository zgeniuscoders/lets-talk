<?php


namespace App\Controllers;

use Zgeniuscoders\Zgeniuscoders\Router\Router;
use Zgeniuscoders\Zgeniuscoders\Render\RenderInterface;


class UserController extends Controller
{
    private $render;

    public function __construct(Router $router, RenderInterface $render)
    {
        $this->render = $render;
        $router->get('/connexion', [$this, 'login'], 'user.login');
        $router->get('/inscription', [$this, 'register'], 'user.register');
        // $router->get('/mot-de-pass-oublier', [$this, 'forgot'], 'user.forgot');
        $router->get('/reinitialisation-mot-de-pass', [$this, 'register'], 'user.reset');
    }

    public function login()
    {
        return $this->render->render('auth/login');
    }

    public function register()
    {
        return $this->render->render('auth/register');
    }

    public function forget()
    {
        return $this->render->render('auth/forget');
    }

    public function reset()
    {
        return $this->render->render('auth/reset');
    }
}
