<?php

namespace Fourum\Permission\Eloquent;

use Fourum\Model\Permission\ThreadPermission;
use Fourum\Permission\PermissibleInterface;
use Fourum\Permission\Permission;
use Fourum\Permission\PermissionRepositoryInterface;
use Fourum\Permission\PermissiveInterface;

class ThreadPermissionRepository implements PermissionRepositoryInterface
{
    /**
     * @param string $name
     * @param PermissibleInterface $permissible
     * @param PermissiveInterface $permissive
     * @return Permission
     */
    public function getByNameAndPermissible($name, PermissibleInterface $permissible, PermissiveInterface $permissive= null)
    {
        $builder = ThreadPermission::where('name', $name)->where($permissible->getForeignKey(), $permissible->getId());
        $permission = $builder->get();

        if ($permission) {
            return new Permission($name, $permission->value, $permissible);
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