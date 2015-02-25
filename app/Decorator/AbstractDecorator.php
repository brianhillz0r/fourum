<?php

namespace Fourum\Decorator;

abstract class AbstractDecorator
{
    /**
     * @var mixed
     */
    protected $decorated;

    /**
     * @param mixed $decorated
     */
    public function __construct($decorated)
    {
        $this->decorated = $decorated;
    }

    /**
     * @return mixed
     */
    public function getDecorated()
    {
        return $this->decorated;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this->decorated, $name), $arguments);
    }
}