<?php

namespace Fourum\Effect\Eloquent;

use Carbon\Carbon;
use Fourum\Effect\EffectableInterface;
use Fourum\Effect\EffectInterface;
use Fourum\Effect\EffectRepositoryInterface;
use Fourum\Model\Effect;
use Fourum\Permission\PermissibleInterface;
use Illuminate\Support\Collection;

class EffectRepository implements EffectRepositoryInterface
{
    /**
     * @param PermissibleInterface $permissible
     * @param string $permissionName
     * @return Collection
     */
    public function getEffectsForPermissible(PermissibleInterface $permissible, $permissionName)
    {
        return Effect::where('permission', '=', $permissionName)
            ->where('foreign_id', '=', $permissible->getId())
            ->where('foreign_key', '=', $permissible->getForeignKey())
            ->where('expires', '>', new Carbon())
            ->get();
    }

    /**
     * @param EffectableInterface $effectable
     * @param EffectInterface $effect
     * @param Carbon $expires
     * @param bool $permissionValue
     * @return mixed
     */
    public function createAndSave(EffectableInterface $effectable, EffectInterface $effect, Carbon $expires, $permissionValue)
    {
        return Effect::create([
            'foreign_id' => $effectable->getId(),
            'foreign_key' => $effectable->getForeignKey(),
            'effect' => $effect->getInternalName(),
            'permission' => $effect->getPermissionName(),
            'permission_value' => $permissionValue,
            'expires' => $expires
        ]);
    }

    /**
     * @param EffectableInterface $effectable
     * @return Collection
     */
    public function getEffectsForEffectable(EffectableInterface $effectable)
    {
        return Effect::where('foreign_id', '=', $effectable->getId())
            ->where('foreign_key', '=', $effectable->getForeignKey())
            ->where('expires', '>', new Carbon())
            ->get();
    }
}