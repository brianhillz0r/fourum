<?php

namespace Fourum\Permission\Checker;

use Fourum\Forum\ForumInterface;
use Fourum\Permission\PermissibleInterface;
use Fourum\Permission\PermissiveInterface;

class ForumChecker extends Checker
{
    /**
     * @param PermissibleInterface $permissible
     * @param PermissiveInterface $permissive
     * @return bool
     */
    public function supports(PermissibleInterface $permissible, PermissiveInterface $permissive = null)
    {
        return $permissible instanceof ForumInterface;
    }
}