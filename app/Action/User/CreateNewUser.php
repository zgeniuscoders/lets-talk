<?php


namespace App\Action\User;

use App\Controllers\Controller;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Legacy\Legacy\Database\DatabaseAuth;
use Legacy\Legacy\Render\RenderInterface;
use Legacy\Legacy\Router\Router;
use Legacy\Legacy\Validation\Validator;

class CreateNewUser extends Controller
{

    public function __construct(Router $router, RenderInterface $render,DatabaseAuth $auth,EntityManager $em)
    {
        parent::__construct($router, $render,$em,$auth);
        $this->router->post('/register', [$this, 'create'], 'user.register.create');
    }

    /**
     * @param ServerRequest $request
     * @return ResponseInterface
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(ServerRequest $request)
    {
        $validator = $this->getValidator($request);

        if($validator->isValid())
        {
            $user = $this->auth->register($request);

            if(!is_null($user))
            {
                return $this->redirect('home');
            }

        }

        $errors = $validator->errors();
        return $this->render->render('auth/register',compact('errors'));
    }

    /**
     * @param ServerRequest $request
     * @return Validator
     */
    private function getValidator(ServerRequest $request): Validator
    {
        return (new Validator(array_merge($request->getParsedBody(),$request->getUploadedFiles())))
            ->required('name','pseudo','email','password','profile')
            ->notEmpty('name','pseudo','email','password','profile')
            ->extension('profile',['jpg','png'])
            ->email('email')
            ->length('password',6);
    }
}