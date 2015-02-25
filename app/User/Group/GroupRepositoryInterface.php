<?php

namespace Fourum\User\Group;

use Fourum\Group\GroupInterface;
use Fourum\Repository\RepositoryInterface;
use Fourum\User\UserInterface;

interface GroupRepositoryInterface extends RepositoryInterface
{
    /**
     * @param UserInterface $user
     * @param GroupInterface $group
     */
    public function assign(UserInterface $user, GroupInterface $group);

    /**
     * @param UserInterface $user
     * @param GroupInterface $group
     */
    public function remove(UserInterface $user, GroupInterface $group);

    /**
     * @param UserInterface $user
     * @param GroupInterface $group
     * @return bool
     */
    public function isInGroup(UserInterface $user, GroupInterface $group);

    /**
     * @param UserInterface $user
     * @param $groupName
     * @return bool
     */
    public function isInGroupName(UserInterface $user, $groupName);
}