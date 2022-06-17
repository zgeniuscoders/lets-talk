<?php

namespace App\Controllers;

use App\Models\User;
use Doctrine\ORM\EntityManager;
use Legacy\Legacy\Auth\AuthInterface;
use Legacy\Legacy\Router\Router;
use Psr\Http\Message\ServerRequestInterface as Request;
use Legacy\Legacy\Render\RenderInterface;

class MainController extends Controller
{

    public function __construct(Router $router, RenderInterface $render, EntityManager $em, AuthInterface $auth)
    {
        parent::__construct($router, $render,$em,$auth);
        $this->router->get('/',[$this, 'index'],'home');
        $this->em = $em;
    }

    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        $users = $this->getRepository(User::class)->getUsers($this->auth()->getId());

        return $this->render->render('index',[
            'users' => $users
        ]);
    }
}