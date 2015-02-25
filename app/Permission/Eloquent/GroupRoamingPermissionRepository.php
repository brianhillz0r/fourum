<?php

namespace Fourum\Permission\Eloquent;

use Fourum\Model\Permission\GroupRoamingPermission;
use Fourum\Permission\PermissibleInterface;
use Fourum\Permission\Permission;
use Fourum\Permission\PermissionRepositoryInterface;
use Fourum\Permission\PermissiveInterface;

class GroupRoamingPermissionRepository implements PermissionRepositoryInterface
{
    /**
     * @param string $name
     * @param PermissibleInterface $permissible
     * @param PermissiveInterface $permissive
     * @return Permission
     */
    public function getByNameAndPermissible($name, PermissibleInterface $permissible, PermissiveInterface $permissive = null)
    {
        if ($permissive) {
            $builder = GroupRoamingPermission::where('name', $name);
            $builder->where($permissible->getForeignKey(), $permissible->getId());
            $builder->where($permissive->getForeignKey(), $permissive->getId());
            $permission = $builder->get();

            if ($permission) {
                return new Permission($name, $permission->value, $permissible, $permissive);
            }
        }
    }

    /**
     * @param Permission $permission
     * @return Permission
     */
    public function get(Permission $permission)
    {
        // TODO: Implement get() method.
    }

    /**
     * @param Permission $permission
     * @return Permission
     */
    public function createAndSave(Permission $permission)
    {
        // TODO: Implement createAndSave() method.
    }

    /**
     * @param Permission $permission
     */
    public function save(Permission $permission)
    {
        // TODO: Implement save() method.
    }

    /**
     * @return array
     */
    public function getPermissionNames()
    {
        // TODO: Implement getPermissionNames() method.
    }
}