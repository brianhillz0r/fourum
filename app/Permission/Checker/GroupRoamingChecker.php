<?php

namespace Fourum\Permission\Checker;

use Fourum\Group\GroupInterface;
use Fourum\Permission\PermissibleInterface;
use Fourum\Permission\PermissiveInterface;

class GroupRoamingChecker extends Checker
{
    /**
     * @param PermissibleInterface $permissible
     * @param PermissiveInterface $permissive
     * @return bool
     */
    public function supports(PermissibleInterface $permissible, PermissiveInterface $permissive = null)
    {
        return $permissible instanceof GroupInterface && ! is_null($permissive);
    }
}