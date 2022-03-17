<?php


namespace Zgeniuscoders\Zgeniuscoders\Render;


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRender implements RenderInterface
{
    /**
     * @var [type] $twig
     */
    private $twig;

    /**
     * @var [type]
     */
    private $loader;

    /**
     * @param string $path
     */
    public function __construct(FilesystemLoader $loader,Environment $twig)
    {
        $this->loader = $loader;
        $this->twig = $twig;
    }
    /**
     * Permet de rajouter des variables global a tout les vues
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function addGlobal(string $key, $value)
    {
        $this->twig->addGlobal($key, $value);
    }

    /**
     * Undocumented function
     *
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view, array $params = [])
    {
        return $this->twig->render($view . ".twig", $params);
    }

    /**
     * Permet de rajouter un chemin pour le vues
     *
     * @param string $namespace
     * @param null|string $path
     * @return void
     */
    public function addPath(string $namespace, $path = null)
    {
        $this->loader->addPath($path, $namespace);
    }

    public function addFunction($function)
    {
        $this->twig->addFunction($function);
    }
}