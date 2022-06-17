<?php


namespace Legacy\Legacy\Session;

interface SessionInterface
{
    /**
     * @param string $key
     * @param $default
     * @return mixed
     */
    public function get(string $key, $default = null): mixed;

    /**
     * @param string $key
     * @param $value
     * @return void
     */
    public function set(string $key, $value): void;

    /**
     * @param string $key
     * @return void
     */
    public function delete(string $key): void;
}
