<?php

namespace Fourum\Permission\Eloquent;

use Fourum\Model\Permission\UserPermission;
use Fourum\Permission\PermissibleInterface;
use Fourum\Permission\Permission;
use Fourum\Permission\PermissiveInterface;
use Fourum\Permission\UserPermissionRepositoryInterface;
use Fourum\User\UserInterface;

class UserPermissionRepository implements UserPermissionRepositoryInterface
{
    const CAN_POST = 'can-post';
    const CAN_POST_NEW = 'can-post-new';
    const CAN_VIEW = 'can-view';
    const CAN_CHANGE_USERNAME = 'can-change-username';

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
        UserPermission::create(array(
            'user_id' => $permission->getPermissible()->getId(),
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

        $userPermission = UserPermission::where('name', $permission->getName())
            ->where($permission->getPermissible()->getForeignKey(), $permission->getPermissible()->getId())
            ->first();
        $userPermission->setValue($permission->getValue());
        $userPermission->save();

        return $permission;
    }

    /**
     * @param UserInterface $user
     * @param string $name
     * @return Permission
     */
    public function getByUserAndName(UserInterface $user, $name)
    {
        $permission = UserPermission::where('user_id', $user->getId())->where('name', $name)->first();

        return new Permission($name, $permission->value, $user);
    }

    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function getByUser(UserInterface $user)
    {
        return UserPermission::where('user_id', $user->getId())->get()->all();
    }

    /**
     * @param string $name
     * @param PermissibleInterface $permissible
     * @param PermissiveInterface $permissive
     * @return Permission
     */
    public function getByNameAndPermissible($name, PermissibleInterface $permissible, PermissiveInterface $permissive = null)
    {
        $builder = UserPermission::where('name', $name)->where($permissible->getForeignKey(), $permissible->getId());
        $permission = $builder->first();

        if ($permission) {
            return new Permission($name, $permission->value, $permissible);
        }
    }

    /**
     * @return array
     */
    public function getPermissionNames()
    {
        return array(
            self::CAN_POST,
            self::CAN_POST_NEW,
            self::CAN_VIEW,
            self::CAN_CHANGE_USERNAME
        );
    }
}