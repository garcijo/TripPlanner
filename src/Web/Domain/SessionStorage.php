<?php

namespace Web\Domain;

use Exception;

class SessionStorage
{
    public function __construct()
    {
        $this->start();
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
        return $this;
    }

    public function unset($key)
    {
        unset($_SESSION[$key]);
        return $this;
    }

    public function merge($key, array $data)
    {
        $current = $this->has($key) ? $this->get($key) : [];
        if (!is_array($current)) {
            throw new Exception('Expected an array');
        }
        $this->set($key, $current + $data);
        return $this;
    }

    public function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public function has($key)
    {
        return array_key_exists($key, $_SESSION);
    }

    public function data()
    {
        return $_SESSION;
    }

    public function isActive()
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public function start()
    {
        if (!$this->isActive()) {
            if (!session_start()) {
                throw new Exception('Session start fail');
            }
        }
    }

    public function destroy()
    {
        session_destroy();
        session_unset();
    }
}
