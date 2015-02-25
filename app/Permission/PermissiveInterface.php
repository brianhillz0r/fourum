<?php

namespace Fourum\Permission;

interface PermissiveInterface
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