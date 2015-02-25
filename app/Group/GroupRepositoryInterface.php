<?php

namespace Fourum\Group;

use Fourum\Repository\RepositoryInterface;

interface GroupRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $name
     * @return GroupInterface
     */
    public function getByName($name);
}