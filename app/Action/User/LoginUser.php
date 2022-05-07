<?php

namespace App\Action\User;

use App\Controllers\Controller;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Psr7\ServerRequest;
use Zgeniuscoders\Zgeniuscoders\Database\DatabaseAuth;
use Zgeniuscoders\Zgeniuscoders\Helpers\Redirect;
use Zgeniuscoders\Zgeniuscoders\Render\RenderInterface;
use Zgeniuscoders\Zgeniuscoders\Router\Router;
use Zgeniuscoders\Zgeniuscoders\Session\Flash;
use Zgeniuscoders\Zgeniuscoders\Session\SessionInterface;

class LoginUser extends Controller
{
    /**
     * @var DatabaseAuth
     */
    private DatabaseAuth $auth;

    /**
     * @var SessionInterface
     */
    private SessionInterface $session;

    public function __construct(Router $router, RenderInterface $render,DatabaseAuth $auth,SessionInterface $session,EntityManager $em)
    {
        parent::__construct($router, $render,$em);
        $this->router->post('/login', [$this, 'login'], 'login');
        $this->auth = $auth;
        $this->session = $session;
    }

    public function login(ServerRequest $request)
    {

        $params = $request->getParsedBody();
        $user = $this->auth->login($params["email"],$params["password"]);

        if(!is_null($user))
        {
            $uri = $this->session->get('redirect') ?: $this->router->getUri('home');
            $this->session->delete('redirect');
            return new Redirect($uri);
        }else{
            (new Flash($this->session))->error('Adress mail ou Mot de pass incorect');
            return $this->redirect('user.login');
        }
    }

}