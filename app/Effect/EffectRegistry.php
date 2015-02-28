<?php

namespace Fourum\Effect;

use Closure;
use Illuminate\Contracts\Support\Arrayable;

class EffectRegistry implements Arrayable
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
        $this->effects[$effect->getInternalName()] = $effect;
    }

    /**
     * @param $name
     * @return EffectInterface
     */
    public function get($name)
    {
        return $this->effects[$name];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->effects;
    }

    /**
     * @param Closure $closure
     * @return array
     */
    public function filter(Closure $closure)
    {
        return array_filter($this->effects, $closure);
    }
}
