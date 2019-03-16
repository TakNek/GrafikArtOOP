<?php
namespace Framework\Session;

class ArraySession implements SessionInterface
{
    private $session;

    /**
     * Recupère une information en Session
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        if (array_key_exists($key, $this->session)) {
            return $this->session[$key];
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
        $this->session[$key] = $value;
    }

    /**
     * Supprime une information de la Session
     *
     * @param string $key
     * @return void
     */
    public function delete(string $key) :void
    {
        unset($this->session[$key]);
    }
}