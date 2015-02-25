<?php

namespace Fourum\Permission\Eloquent;

use Fourum\Model\Permission\GroupPermission;
use Fourum\Permission\GroupPermissionRepositoryInterface;
use Fourum\Permission\PermissibleInterface;
use Fourum\Permission\Permission;
use Fourum\Permission\PermissiveInterface;

class GroupPermissionRepository implements GroupPermissionRepositoryInterface
{
    const CAN_ADMINISTRATE = 'can-administrate';
    const CAN_MODERATE = 'can-moderate';

    /**
     * @param string $name
     * @param PermissibleInterface $permissible
     * @param PermissiveInterface $permissive
     * @return Permission
     */
    public function getByNameAndPermissible($name, PermissibleInterface $permissible, PermissiveInterface $permissive = null)
    {
        $builder = GroupPermission::where('name', $name)->where($permissible->getForeignKey(), $permissible->getId());
        $permission = $builder->first();

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
        return $this->getByNameAndPermissible($permission->getName(), $permission->getPermissible());
    }

    /**
     * @param Permission $permission
     * @return Permission
     */
    public function createAndSave(Permission $permission)
    {
        GroupPermission::create(array(
            'group_id' => $permission->getPermissible()->getId(),
            'name' => $permission->getName(),
            'value' => $permission->getValue()
        ));

        return $permission;
    }

    /**
     * @param Permission $permission
     * @return Permission
     */
    public function save(Permission $permission)
    {
        if (! $this->get($permission)) {
            return $this->createAndSave($permission);
        }

        $groupPermission = GroupPermission::where('name', $permission->getName())
            ->where($permission->getPermissible()->getForeignKey(), $permission->getPermissible()->getId())
            ->first();
        $groupPermission->setValue($permission->getValue());
        $groupPermission->save();

        return $permission;
    }

    /**
     * @return array
     */
    public function getPermissionNames()
    {
        return array(
            self::CAN_ADMINISTRATE,
            self::CAN_MODERATE,
            UserPermissionRepository::CAN_POST,
            UserPermissionRepository::CAN_POST_NEW,
            UserPermissionRepository::CAN_VIEW,
            UserPermissionRepository::CAN_CHANGE_USERNAME
        );
    }
}