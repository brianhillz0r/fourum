<?php

namespace Fourum\Permission\Checker;

use Fourum\Permission\PermissibleInterface;
use Fourum\Permission\PermissiveInterface;

interface CheckerInterface
{
    /**
     * @param $name
     * @param PermissibleInterface $permissible
     * @param PermissiveInterface $permissive
     * @return bool
     */
    public function checkHard($name, PermissibleInterface $permissible, PermissiveInterface $permissive = null);

    /**
     * @param $name
     * @param PermissibleInterface $permissible
     * @param PermissiveInterface $permissive
     * @param bool $hard
     * @return bool
     */
    public function check($name, PermissibleInterface $permissible, PermissiveInterface $permissive = null, $hard = false);

    /**
     * @param PermissibleInterface $permissible
     * @return bool
     */
    public function supports(PermissibleInterface $permissible);
}