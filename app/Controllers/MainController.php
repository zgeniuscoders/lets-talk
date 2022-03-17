<?php


namespace App\Controllers;


use Zgeniuscoders\Zgeniuscoders\Router\Router;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MainController extends Controller
{
    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $router->get('/',[$this, 'index'],'home');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        echo "fff";
    }
}