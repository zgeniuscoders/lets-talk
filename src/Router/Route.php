<?php

namespace Zgeniuscoders\Zgeniuscoders\Router;

class Route
{
    private $name;
    private $callable;
    private $params;
    /**
     * Undocumented function
     *
     * @param string $name
     * @param callable $callable
     * @param array $params
     */
    public function __construct(string $name, callable $callable, array $params)
    {
        $this->name = $name;
        $this->callable = $callable;
        $this->params = $params;
    }
    /**
     * Undocumented function
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * Undocumented function
     *
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->callable;
    }
    /**
     * Undocumented function
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
