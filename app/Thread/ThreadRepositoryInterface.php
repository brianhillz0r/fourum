<?php

namespace Fourum\Thread;

use Fourum\Repository\RepositoryInterface;

interface ThreadRepositoryInterface extends RepositoryInterface
{
    /**
     * @param array $input
     * @return ThreadInterface
     */
    public function create(array $input);
}