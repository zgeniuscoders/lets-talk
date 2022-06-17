<?php

namespace Legacy\Legacy\Router;

class Route
{
    /**
     * Undocumented function
     *
     * @param string $name
     * @param $callable
     * @param array $params
     */
    public function __construct(
        private string $name,
        private $callable,
        private array $params
    ) {
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
