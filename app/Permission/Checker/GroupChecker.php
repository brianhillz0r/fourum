<?php

namespace Fourum\Permission\Checker;

use Fourum\Group\GroupInterface;
use Fourum\Permission\PermissibleInterface;
use Fourum\Permission\PermissiveInterface;

class GroupChecker extends Checker
{
    /**
     * @param PermissibleInterface $permissible
     * @param PermissiveInterface $permissive
     * @return bool
     */
    public function supports(PermissibleInterface $permissible, PermissiveInterface $permissive = null)
    {
        return $permissible instanceof GroupInterface;
    }
}