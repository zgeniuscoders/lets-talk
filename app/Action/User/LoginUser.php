<?php

namespace App\Action\User;

use App\Controllers\Controller;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Psr7\ServerRequest;
use Legacy\Legacy\Database\DatabaseAuth;
use Legacy\Legacy\Helpers\Redirect;
use Legacy\Legacy\Render\RenderInterface;
use Legacy\Legacy\Router\Router;
use Legacy\Legacy\Session\Flash;
use Legacy\Legacy\Session\SessionInterface;

class LoginUser extends Controller
{
    /**
     * @var SessionInterface
     */
    private SessionInterface $session;

    public function __construct(Router $router, RenderInterface $render,DatabaseAuth $auth,SessionInterface $session,EntityManager $em)
    {
        parent::__construct($router, $render,$em,$auth);
        $this->router->post('/login', [$this, 'login'], 'login');
        $this->session = $session;
    }

    public function login(ServerRequest $request): \Psr\Http\Message\ResponseInterface|Redirect
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