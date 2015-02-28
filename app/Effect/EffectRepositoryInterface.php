<?php

namespace Fourum\Effect;

use Carbon\Carbon;
use Fourum\Permission\PermissibleInterface;
use Illuminate\Support\Collection;

interface EffectRepositoryInterface
{
    /**
     * @param PermissibleInterface $permissible
     * @param string $permissionName
     * @return Collection
     */
    public function getEffectsForPermissible(PermissibleInterface $permissible, $permissionName);

    /**
     * @param EffectableInterface $effectable
     * @return Collection
     */
    public function getEffectsForEffectable(EffectableInterface $effectable);

    /**
     * @param EffectableInterface $effectable
     * @param EffectInterface $effect
     * @param Carbon $expires
     * @param bool $permissionValue
     * @return mixed
     */
    public function createAndSave(EffectableInterface $effectable, EffectInterface $effect, Carbon $expires, $permissionValue);
}