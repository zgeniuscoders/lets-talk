<?php


namespace App\Action\User;


use App\Controllers\Controller;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use GuzzleHttp\Psr7\ServerRequest;
use Legacy\Legacy\Database\DatabaseAuth;
use Legacy\Legacy\Helpers\Redirect;
use Legacy\Legacy\Render\RenderInterface;
use Legacy\Legacy\Router\Router;
use Legacy\Legacy\Session\Flash;

class Logout extends Controller
{
    /**
     * @var Flash
     */
    private Flash $flash;

    public function __construct(Router $router, RenderInterface $render, Flash $flash, DatabaseAuth $auth,EntityManager $em)
    {
        parent::__construct($router, $render,$em,$auth);
        $this->router->post('/logout', [$this, 'logout'], 'logout');
        $this->flash = $flash;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function logout(ServerRequest $request)
    {
        $this->auth->logout($request->getParsedBody()["uuid"]);
        return new Redirect('/login');
    }
}