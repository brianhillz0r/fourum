<?php

namespace Fourum\Effect;

use Fourum\Group\GroupInterface;
use Fourum\User\UserInterface;

class SuspendPosting implements EffectInterface
{
    /**
     * @param EffectableInterface $effectable
     * @param EffectConfiguration $config
     */
    public function apply(EffectableInterface $effectable, EffectConfiguration $config)
    {
    }

    /**
     * @param EffectableInterface $effectable
     * @param EffectConfiguration $config
     * @return bool
     */
    public function supports(EffectableInterface $effectable, EffectConfiguration $config)
    {
        return $effectable instanceof UserInterface || $effectable instanceof GroupInterface;
    }

    /**
     * @return string
     */
    public function getName()
    {
    }

    /**
     * @return string
     */
    public function getDescription()
    {
    }
}