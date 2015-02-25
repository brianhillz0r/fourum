<?php

namespace Fourum\Condition;

interface PassableInterface
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