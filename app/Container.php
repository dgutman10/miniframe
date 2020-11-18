<?php

namespace App;


use Closure;
use ReflectionClass;
use ReflectionException;

class Container
{
    /** @var Container  */
    protected static $instance = null;

    /** @var array */
    private $bindings = [];

    /**
     * @param $key
     * @param $resolver
     */
    public function bind($key, $resolver)
    {
        $this->bindings[$key] = [
            'resolver' => $resolver
        ];
    }

    /**
     * @param $key
     * @return mixed|object
     * @throws ReflectionException
     */
    public function make($key)
    {
        if (isset($this->bindings[$key])) {
            $resolver = $this->bindings[$key]['resolver'];
        } else {
            $resolver = $key;
        }

        if ($resolver instanceof Closure)
        {
            return $resolver($this);
        }

        return $this->build($resolver);
    }

    /**
     * @param $class
     * @return mixed|object
     * @throws ReflectionException
     */
    public function build($class)
    {
        $reflectionClass = new ReflectionClass($class);

        $constructor = $reflectionClass->getConstructor();

        if ($constructor == null) {
            return new $class;
        }

        $parameters = $constructor->getParameters();

        $arguments = [];

        foreach ($parameters as $parameter) {
            $className = $parameter->getClass()->getName();
            $arguments[] = $this->build($className);
        }

        return $reflectionClass->newInstanceArgs($arguments);
    }

    /**
     * @return Container
     */
    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance = new static;
        }

        return static::$instance;
    }
}