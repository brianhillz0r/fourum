<?php

namespace Fourum\Permission;

interface PermissionRepositoryInterface
{
    /**
     * @param string $name
     * @param PermissibleInterface $permissable
     * @param PermissiveInterface $permissive
     * @return Permission
     */
    public function getByNameAndPermissible($name, PermissibleInterface $permissable, PermissiveInterface $permissive = null);

    /**
     * @param Permission $permission
     * @return Permission
     */
    public function get(Permission $permission);

    /**
     * @param Permission $permission
     * @return Permission
     */
    public function createAndSave(Permission $permission);

    /**
     * @param Permission $permission
     */
    public function save(Permission $permission);

    /**
     * @return array
     */
    public function getPermissionNames();
}