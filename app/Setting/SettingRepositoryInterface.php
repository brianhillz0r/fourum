<?php

namespace Fourum\Setting;

use Fourum\Repository\RepositoryInterface;
use Illuminate\Support\Collection;

interface SettingRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $name (namespace.name)
     * @return SettingInterface
     */
    public function get($name);

    /**
     * @param string $namespace
     * @param string $name
     * @return SettingInterface
     */
    public function getByNamespaceAndName($namespace, $name);

    /**
     * @param string $namespace
     * @return Collection
     */
    public function getByNamespace($namespace);
}