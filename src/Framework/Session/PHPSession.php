<?php
namespace Framework\Session;

class PHPSession implements SessionInterface
{
    /**
     * Recupère une information en Session
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        $this->ensureStarted();
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }
        return $default;
    }

    /**
     * Ajoute une information en Session
     *
     * @param string $key
     * @param [type] $value
     * @return void
     */
    public function set(string $key, $value) :void
    {
        $this->ensureStarted();
        $_SESSION[$key] = $value;
    }

    /**
     * Supprime une information de la Session
     *
     * @param string $key
     * @return void
     */
    public function delete(string $key) :void
    {
        $this->ensureStarted();
        unset($_SESSION[$key]);
    }

    /**
     * Assure que la Session est demarré
     *
     * @return void
     */
    private function ensureStarted()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            $this->ensureStarted();
        }
    }
}
