<?php


namespace App\Controllers;


use GuzzleHttp\Psr7\Response;
use Zgeniuscoders\Zgeniuscoders\Router\Router;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zgeniuscoders\Zgeniuscoders\Render\RenderInterface;

class MainController extends Controller
{
    private $render;
    /**
     * @param Router $router
     */
    public function __construct(Router $router,RenderInterface $render)
    {
        $this->render = $render;
        $router->get('/',[$this, 'index'],'home');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->render->render('index');
    }
}