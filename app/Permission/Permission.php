<?php

namespace Fourum\Permission;

class Permission implements PermissionInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $value;

    /**
     * @var PermissibleInterface
     */
    protected $permissible;

    /**
     * @var PermissiveInterface
     */
    protected $permissive;

    /**
     * @param $name
     * @param $value
     * @param PermissibleInterface $permissible
     * @param PermissiveInterface $permissive
     */
    public function __construct($name, $value, PermissibleInterface $permissible, PermissiveInterface $permissive = null)
    {
        $this->name = $name;
        $this->value = (bool) $value;
        $this->permissible = $permissible;
        $this->permissive = $permissive;
    }

    /**
     * @return bool
     */
    public function getValue()
    {
        return (bool) $this->value;
    }

    /**
     * @param $value
     */
    public function setValue($value)
    {
        $this->value = (bool) $value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return PermissibleInterface
     */
    public function getPermissible()
    {
        return $this->permissible;
    }

    /**
     * @return PermissiveInterface
     */
    public function getPermissive()
    {
        return $this->permissive;
    }
}