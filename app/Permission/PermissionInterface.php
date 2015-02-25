<?php

namespace Fourum\Permission;

interface PermissionInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return bool
     */
    public function getValue();

    /**
     * @param bool $value
     */
    public function setValue($value);

    /**
     * @return PermissibleInterface
     */
    public function getPermissible();

    /**
     * @return PermissiveInterface
     */
    public function getPermissive();
}