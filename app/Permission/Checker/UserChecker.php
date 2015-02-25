<?php

namespace Fourum\Permission\Checker;

use Fourum\Permission\Eloquent\GroupPermissionRepository;
use Fourum\Permission\PermissibleInterface;
use Fourum\Permission\PermissiveInterface;
use Fourum\User\UserInterface;

class UserChecker extends Checker
{
    /**
     * @param string $name
     * @param PermissibleInterface $permissible
     * @param PermissiveInterface $permissive
     * @param bool $hard
     * @return bool
     */
    public function check(
        $name,
        PermissibleInterface $permissible,
        PermissiveInterface $permissive = null,
        $hard = false
    ) {
        $userCheck = parent::check($name, $permissible, $permissive, $hard);

        if ($userCheck) {
            return true;
        }

        $groups = $permissible->getGroups();
        $checker = new GroupChecker(new GroupPermissionRepository());

        foreach ($groups as $group) {
            if ($checker->check($name, $group, $permissive, $hard)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param PermissibleInterface $permissible
     * @param PermissiveInterface $permissive
     * @return bool
     */
    public function supports(PermissibleInterface $permissible, PermissiveInterface $permissive = null)
    {
        return $permissible instanceof UserInterface;
    }
}