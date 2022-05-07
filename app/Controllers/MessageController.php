<?php

namespace App\Controllers;

use App\Models\Message;
use App\Models\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Zgeniuscoders\Zgeniuscoders\Auth\AuthInterface;
use Zgeniuscoders\Zgeniuscoders\Render\RenderInterface;
use Zgeniuscoders\Zgeniuscoders\Router\Router;

class MessageController extends Controller
{

    private AuthInterface $auth;

    public function __construct(Router $router, RenderInterface $render, EntityManager $em, AuthInterface $auth)
    {
        parent::__construct($router, $render, $em);
        $this->router->get('/message/{uuid:[a-z\-0-9]+}',[$this,'index'],'message.index');
        $this->router->post('/message',[$this,'store'],'message.store');
        $this->auth = $auth;
    }

    /**
     * @param ServerRequest $request
     * @return ResponseInterface|string
     */
    public function index(ServerRequest $request): ResponseInterface|string
    {
        $uuid = $request->getAttribute('uuid');
        $id = $this->auth->getUser()->getId();

        $receiver = $this->em->getRepository(User::class)
            ->findOneByUuid($request->getAttribute('uuid'));

        $messages = $this->getRepository(Message::class)->getMessages(2,3);

        return $this->render->render('messages/index',compact('receiver','messages'));

    }

    /**
     * @param ServerRequest $request
     * @return ResponseInterface|string
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function store(ServerRequest $request): ResponseInterface|string
    {
        $params = array_merge($request->getParsedBody());
        $message = new Message;
        $message->setSender($this->auth->getUser()->getId())
            ->setReceive($params['receiver_id'])
            ->setMessage($params['message']);

        $this->em->persist($message);
        $this->em->flush();

        return $this->redirect('message.index');
    }
}