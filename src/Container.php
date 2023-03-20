<?php

namespace App;

use App\Exceptions\ClassNotFoundException;
use App\Exceptions\ContainerException;

class Container implements \Psr\Container\ContainerInterface
{
    private array $entries = [];

    /**
     * @throws ClassNotFoundException
     * @throws \Exception
     */
    public function get(string $id)
    {
        if ($this->has($id)) {
            $entry = $this->entries[$id];

            return $entry($this);
        }

        try {
            return $this->resolve($id);
        } catch (ClassNotFoundException|ContainerException|\ReflectionException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set(string $id, callable $concrete)
    {
        $this->entries[$id] = $concrete;
    }

    /**
     * @throws \ReflectionException
     * @throws ClassNotFoundException|ContainerException
     */
    public function resolve(string $id)
    {
        $reflectionClass = new \ReflectionClass($id);

        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException('Class ' . $id . ' is not instantiable!');
        }

        $constructor = $reflectionClass->getConstructor();

        if (!$constructor) {
            return new $id;
        }

        $parameters = $constructor->getParameters();

        if (!$parameters) {
            return new $id;
        }

        $dependencies = array_map(function (\ReflectionParameter $parameter) {
            $type = $parameter->gettype();

            if (
                $type &&
                !($type instanceof \ReflectionUnionType) &&
                ($type instanceof \ReflectionNamedType) &&
                (!$type->isBuiltin())
            ) {
                return $this->get($type->getName());
            }
        }, $parameters);

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}