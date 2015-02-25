<?php

namespace Fourum\Repository;

use Illuminate\Contracts\Container\Container;

class RepositoryRegistry
{
    /**
     * @var array
     */
    protected $repositories;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     * @param array $repositories
     */
    public function __construct(Container $container, array $repositories = [])
    {
        $this->repositories = $repositories;
        $this->container = $container;
    }

    /**
     * @param string $repositoryName
     * @param string $repositoryClassName
     */
    public function add($repositoryName, $repositoryClassName)
    {
        $this->repositories[$repositoryName] = $repositoryClassName;
    }

    /**
     * @param string $name
     * @return RepositoryInterface
     */
    public function get($name)
    {
        return $this->container->make($this->repositories[$name]);
    }
}