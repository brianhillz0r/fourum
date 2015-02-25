<?php

namespace Fourum\Condition;

interface ConditionInterface
{
    /**
     * @param PassableInterface $passable
     * @return bool
     */
    public function passes(PassableInterface $passable);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getDescription();
}