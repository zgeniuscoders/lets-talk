<?php


namespace App\Controllers;


use App\Models\User;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Psr7\Response;
use Zgeniuscoders\Zgeniuscoders\Router\Router;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zgeniuscoders\Zgeniuscoders\Render\RenderInterface;

class MainController extends Controller
{

    public function __construct(Router $router, RenderInterface $render, EntityManager $em)
    {
        parent::__construct($router, $render,$em);
        $this->router->get('/',[$this, 'index'],'home');
        $this->em = $em;
    }

    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        $users = $this->getRepository(User::class)->getUsers();

        return $this->render->render('index',[
            'users' => $users
        ]);
    }
}