<?php


namespace Zgeniuscoders\Zgeniuscoders\Render;


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRender implements RenderInterface
{
    private FilesystemLoader $twigLoader;
    private Environment $twig;

    /**
     * TwigRender constructor.
     * @param string $viewPath
     */
    public function __construct(string $viewPath)
    {
        $this->twigLoader = new FilesystemLoader($viewPath);
        $this->twig = new Environment($this->twigLoader);
    }

    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    public function render(string $path, ?array $params)
    {
        echo $this->twig->render($path,$params);
    }
}