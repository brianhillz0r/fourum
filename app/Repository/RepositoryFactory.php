<?php

namespace Fourum\Repository;

use Illuminate\Contracts\Container\Container;

class RepositoryFactory
{
    /**
     * @var array
     */
    protected $foreignKeyToClassNames = array(
        'thread_id' => 'Fourum\Thread\ThreadRepositoryInterface',
        'post_id' => 'Fourum\Post\PostRepositoryInterface'
    );

    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $foreignKey
     * @return RepositoryInterface
     */
    public function build($foreignKey)
    {
        $className = $this->getRepositoryClassName($foreignKey);

        $repo = $this->container->make($className);

        if (! $repo instanceof RepositoryInterface) {
            throw new \InvalidArgumentException("{$className} does not implement " . RepositoryInterface::class);
        }

        return $repo;
    }

    /**
     * @param string $foreignKey
     * @param string $className
     */
    public function addForeignKey($foreignKey, $className)
    {
        $this->foreignKeyToClassNames[$foreignKey] = $className;
    }

    /**
     * @param string $foreignKey
     * @return string
     */
    protected function getRepositoryClassName($foreignKey)
    {
        return $this->foreignKeyToClassNames[$foreignKey];
    }
}