<?php

namespace Fourum\Permission\Checker;

use Fourum\Permission\PermissibleInterface;
use Fourum\Permission\PermissiveInterface;

class CheckerSet implements CheckerInterface
{
    /**
     * @var array
     */
    protected $checkers;

    /**
     * @var PermissibleInterface
     */
    protected $permissible;

    /**
     * @param array $checkers
     * @param PermissibleInterface $permissible
     */
    public function __construct(array $checkers, PermissibleInterface $permissible = null)
    {
        foreach ($checkers as $checker) {
            $this->addChecker($checker);
        }

        $this->permissible = $permissible;
    }

    /**
     * @param CheckerInterface $checker
     */
    public function addChecker(CheckerInterface $checker)
    {
        $this->checkers[] = $checker;
    }

    /**
     * @param $name
     * @param PermissibleInterface $permissible
     * @param PermissiveInterface $permissive
     * @param bool $hard
     * @return bool
     */
    public function check(
        $name,
        PermissibleInterface $permissible,
        PermissiveInterface $permissive = null,
        $hard = false
    ) {
        foreach ($this->checkers as $checker) {
            if (! $checker->supports($permissible)) {
                continue;
            }

            if (! $checker->check($name, $permissible, $permissive, $hard)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param $name
     * @param PermissibleInterface $permissible
     * @param PermissiveInterface $permissive
     * @return bool
     */
    public function checkHard($name, PermissibleInterface $permissible, PermissiveInterface $permissive = null)
    {
        return $this->check($name, $permissible, $permissive, true);
    }

    /**
     * @param PermissibleInterface $permissible
     * @param PermissiveInterface $permissive
     * @return bool
     */
    public function supports(PermissibleInterface $permissible, PermissiveInterface $permissive = null)
    {
        return true;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return bool
     */
    public function __call($name, $arguments)
    {
        if ($this->permissible) {
            $name = str_replace('_', '-', $name);
            return $this->check($name, $this->permissible);
        }
    }
}