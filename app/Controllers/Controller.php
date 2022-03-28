<?php


namespace App\Controllers;

use Zgeniuscoders\Zgeniuscoders\Render\RenderInterface;
use Zgeniuscoders\Zgeniuscoders\Render\TwigRender;
use Zgeniuscoders\Zgeniuscoders\Router\Router;

class Controller
{
    protected Router $router;
    protected RenderInterface $render;

    public function __construct(Router $router, RenderInterface $render)
    {
        $this->router = $router;
        $this->render = $render;
    }
}