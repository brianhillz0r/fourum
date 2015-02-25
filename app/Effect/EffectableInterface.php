<?php

namespace Fourum\Effect;

interface EffectableInterface
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
