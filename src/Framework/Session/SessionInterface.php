<?php
namespace Framework\Session;

interface SessionInterface
{

   
    /**
     * Recupère une information en Session
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * Ajoute une information en Session
     *
     * @param string $key
     * @param [type] $value
     * @return void
     */
    public function set(string $key, $value) :void;

    /**
     * Supprime une information de la Session
     *
     * @param string $key
     * @return void
     */
    public function delete(string $key) :void;
}
