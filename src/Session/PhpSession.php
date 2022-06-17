<?php


namespace Legacy\Legacy\Session;

class PhpSession implements SessionInterface, \ArrayAccess
{
    public function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function get(string $key, $default = null): mixed
    {
        $this->start();
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }
        return $default;
    }

    public function set(string $key, $value): void
    {
        $this->start();
        $_SESSION[$key] = $value;
    }

    public function delete(string $key): void
    {
        $this->start();
        unset($_SESSION[$key]);
    }

    public function offsetExists($offset)
    {
        $this->start();
        return array_key_exists($offset, $_SESSION);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->delete($offset);
    }
}
