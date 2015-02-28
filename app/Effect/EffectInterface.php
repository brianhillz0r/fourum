<?php

namespace Fourum\Effect;

interface EffectInterface
{
    /**
     * @param EffectableInterface $effectable
     * @param EffectConfiguration $config
     */
    public function apply(EffectableInterface $effectable, EffectConfiguration $config);

    /**
     * @param EffectableInterface $effectable
     * @return bool
     */
    public function supports(EffectableInterface $effectable);

    /**
     * @return string
     */
    public function getPermissionName();

    /**
     * @return string
     */
    public function getInternalName();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getDescription();
}
