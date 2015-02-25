<?php

namespace Fourum\Permission;

interface PermissibleInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getForeignKey();
}