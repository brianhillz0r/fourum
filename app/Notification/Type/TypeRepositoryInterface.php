<?php

namespace Fourum\Notification\Type;

use Fourum\Model\Notification\Type;
use Fourum\Repository\RepositoryInterface;

interface TypeRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $name
     * @return Type
     */
    public function getByName($name);

    /**
     * @param string $name
     * @return bool
     */
    public function hasType($name);
}