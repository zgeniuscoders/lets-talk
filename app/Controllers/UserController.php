<?php


namespace App\Controllers;

use App\Models\User;
use GuzzleHttp\Psr7\ServerRequest;
use Zgeniuscoders\Zgeniuscoders\Database\DBConnection;
use Zgeniuscoders\Zgeniuscoders\Router\Router;
use Zgeniuscoders\Zgeniuscoders\Render\RenderInterface;
use Zgeniuscoders\Zgeniuscoders\Validation\Validator;

class UserController
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

    /**
     * @return mixed
     */
    public function login()
    {
        return $this->render->render('auth/login');
    }

    /**
     * @param ServerRequest $request
     * @return mixed
     */
    public function create(ServerRequest $request)
    {
        $validator = $this->getValidator($request);
            $user = new User($this->db);
            $password = password_hash($request->getParsedBody()["password"],PASSWORD_BCRYPT);

            $user->create([
                'uuid' => uniqid(),
                'name' => $request->getParsedBody()["name"],
                'pseudo' => $request->getParsedBody()["pseudo"],
                'email' => $request->getParsedBody()["email"],
                'password' => $password,
                'profil' => '1.jpg'
            ]);
            dd("okay");

//
//        $errors = $validator->errors();
//        dd($errors);
//        return $this->render->render('auth/register',compact('errors'));

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

    /**
     * @param ServerRequest $request
     * @return Validator
     */
    private function getValidator(ServerRequest $request): Validator
    {
        return (new Validator([
            $request->getParsedBody()["name"],
            $request->getParsedBody()["email"],
            $request->getParsedBody()["password"],
            $request->getParsedBody()["pseudo"]
        ]))
            ->required('name','pseudo','email','password')
            ->notEmpty('name','pseudo','email','password')
            ->length('password',6);
    }
}
