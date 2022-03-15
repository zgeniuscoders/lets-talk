<?php

namespace Zgeniuscoders\Zgeniuscoders\Router;

use Zgeniuscoders\Zgeniuscoders\Router\Exceptions\RouteExceptions;

class Route
{
    private string $path;
    private $callable;
    private array $matches = [];
    private array $params = [];
    private string $name;

    /**
     * Undocumented function
     *
     * @param string $path
     * @param callable $callable
     * @param string $name
     */
    public function __construct(string $path, callable|array $callable, string $name)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
        $this->$name = $name;
    }

    /**
     * @param [type] $match
     * @return string
     */
    private function paramMatch($match): string
    {
        if (isset($this->params[$match[1]])) {
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    /**
     * permet de verifier si l'url correspond a une route
     * @param string $url
     * @return bool
     */
    public function matches(string $url): bool
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }


    /**
     * permet d'obtenir url d'une route
     * @param array $params
     * @return string
     */
    public function getUrl(array $params): string
    {
        $path = $this->path;
        foreach ($params as $k => $v) {
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }

    /**
     * permet d'obtenir le nom d'un route
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return callable
     */
    public function getCallable(): callable
    {
        return $this->callable;
    }

    /**
     * permet d'obtenir le parametre de l'url
     * @return array
     */
    public function getParams(): array
    {
        return $this->matches;
    }

    public function call()
    {
        if (is_array($this->callable)) {

            $controller = $this->callable[0];
            $method =  $this->callable[1];

            if (class_exists($controller) && method_exists($controller, $method)) {
                $controller = new $controller();
                return call_user_func_array([$controller, $method], $this->matches);
            }

            throw new RouteExceptions("the class called or the method called doesn't exist");
        } else {
            return new Route($this->path, $this->callable, $this->name);
            // return call_user_func_array($this->callable, $this->matches);
        }
    }
}
