<?php

namespace Framework\Router;

/**
 * Class Route
 * Represents a matched Route
 */
class Route
{
    
    private $name;
    private $callback;
    private $parameters=[];

    public function __construct(string $name, $callback, array $parameters)
    {
        $this->name=$name;
        $this->callback=$callback;
        $this->parameters=$parameters;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     *
     * @return callable
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Retrive URL parameters
     * @return string[]
     */
    public function getParams(): array
    {
        return $this->parameters;
    }
}
