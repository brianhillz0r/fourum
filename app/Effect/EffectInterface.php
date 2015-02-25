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
     * @param EffectConfiguration $config
     * @return bool
     */
    public function supports(EffectableInterface $effectable, EffectConfiguration $config);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getDescription();
}
