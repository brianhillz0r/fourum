<?php

namespace Fourum\Effect;

class EffectRegistry
{
    /**
     * @var array
     */
    protected $effects;

    /**
     * @param array $effects
     */
    public function __construct(array $effects)
    {
        foreach ($effects as $effect) {
            $this->addEffect($effect);
        }
    }

    /**
     * @param EffectInterface $effect
     */
    public function addEffect(EffectInterface $effect)
    {
        $this->effects[$effect->getName()] = $effect;
    }

    /**
     * @param $name
     * @return EffectInterface
     */
    public function get($name)
    {
        return $this->effects[$name];
    }
}
