<?php

namespace Fourum\Effect;

use Fourum\Group\GroupInterface;
use Fourum\Permission\Eloquent\UserPermissionRepository;
use Fourum\User\UserInterface;

class SuspendPosting implements EffectInterface
{
    /**
     * @var EffectRepositoryInterface
     */
    protected $effects;

    /**
     * @param EffectRepositoryInterface $effects
     */
    public function __construct(EffectRepositoryInterface $effects)
    {
        $this->effects = $effects;
    }

    /**
     * @param EffectableInterface $effectable
     * @param EffectConfiguration $config
     */
    public function apply(EffectableInterface $effectable, EffectConfiguration $config)
    {
        // create record in effects table, with id, foreign key, name and expiry based on config
        $this->effects->createAndSave($effectable, $this, $config->getExpiry(), false);
    }

    /**
     * @param EffectableInterface $effectable
     * @return bool
     */
    public function supports(EffectableInterface $effectable)
    {
        return $effectable instanceof UserInterface || $effectable instanceof GroupInterface;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Suspend Posting';
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'Prevents the subject from being able to post anywhere on the forum.';
    }

    /**
     * @return string
     */
    public function getInternalName()
    {
        return 'suspend-posting';
    }

    /**
     * @return string
     */
    public function getPermissionName()
    {
        return UserPermissionRepository::CAN_POST;
    }
}