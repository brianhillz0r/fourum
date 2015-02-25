<?php

namespace Fourum\Permission\Checker;

use Fourum\Permission\PermissibleInterface;
use Fourum\Permission\PermissiveInterface;
use Fourum\Thread\ThreadInterface;

class ThreadChecker extends Checker
{
    /**
     * @param PermissibleInterface $permissible
     * @param PermissiveInterface $permissive
     * @return bool
     */
    public function supports(PermissibleInterface $permissible, PermissiveInterface $permissive = null)
    {
        return $permissible instanceof ThreadInterface;
    }
}