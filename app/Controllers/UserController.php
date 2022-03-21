<?php


namespace App\Controllers;

use App\Model\User;
use App\Request\UserRequest;
use GuzzleHttp\Psr7\ServerRequest;
use Zgeniuscoders\Zgeniuscoders\Database\DBConnection;
use Zgeniuscoders\Zgeniuscoders\Router\Router;
use Zgeniuscoders\Zgeniuscoders\Render\RenderInterface;
use function Zgeniuscoders\Zgeniuscoders\Helpers\store;

class UserController extends Controller
{
    /**
     * permet de rendre les vue twig
     * @var RenderInterface
     */
    private RenderInterface $render;

    /**
     * @var DBConnection
     */
    private DBConnection $db;

    public function __construct(Router $router, RenderInterface $render, DBConnection $db)
    {
        $this->db = $db;
        $this->render = $render;
        $router->get('/connexion', [$this, 'login'], 'user.login');

        $router->get('/inscription', [$this, 'register'], 'user.register');
        $router->post('/inscription', [$this, 'create'], 'user.register.create');
        // $router->get('/mot-de-pass-oublier', [$this, 'forgot'], 'user.forgot');
        $router->get('/reinitialisation-mot-de-pass', [$this, 'register'], 'user.reset');
    }

    public function login()
    {
        return $this->render->render('auth/login');
    }

    public function create(ServerRequest $request,UserRequest $userRequest)
    {
        // $user = new User($this->db);
        // $validator = new UserRequest($request->getParsedBody(),$user);
        // // $avatar = store($_FILES);

        // dd($validator->errors());

        // if ($validator->validate()) {
        //     $user->create([
        //         'uuid' => uniqid(),
        //         'name' => $request->getParsedBody()["name"],
        //         'pseudo' => $request->getParsedBody()["pseudo"],
        //         'email' => $request->getParsedBody()["email"],
        //         'password' => password_hash($request->getParsedBody()["password"], PASSWORD_BCRYPT),
        //         'profil' => $avatar
        //     ]);
        // }
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
