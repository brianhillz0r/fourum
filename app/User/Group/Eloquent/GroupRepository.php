<?php

namespace Fourum\User\Group\Eloquent;

use Fourum\Group\GroupInterface;
use Fourum\Model\User\Group;
use Fourum\User\Group\GroupRepositoryInterface;
use Fourum\User\UserInterface;
use Illuminate\Support\Collection;

class GroupRepository implements GroupRepositoryInterface
{
    /**
     * @var \Fourum\Group\GroupRepositoryInterface
     */
    protected $groups;

    public function __construct(\Fourum\Group\GroupRepositoryInterface $groups)
    {
        $this->groups = $groups;
    }

    /**
     * @return Collection
     */
    public function getAll()
    {
        return Group::all();
    }

    /**
     * @param int $id
     * @return Group
     */
    public function get($id)
    {
        return Group::find($id);
    }

    /**
     * @param UserInterface $user
     * @param GroupInterface $group
     * @return Group
     */
    public function assign(UserInterface $user, GroupInterface $group)
    {
        $userGroup = array(
            'user_id' => $user->getId(),
            'group_id' => $group->getId()
        );

        return $this->createAndSave($userGroup);
    }

    /**
     * @param array $input
     * @return mixed
     */
    public function createAndSave(array $input)
    {
        return Group::create($input);
    }

    /**
     * @param UserInterface $user
     * @param GroupInterface $group
     * @return bool
     */
    public function isInGroup(UserInterface $user, GroupInterface $group)
    {
        return Group::where('user_id', $user->getId())->where('group_id', $group->getId())->count() > 0;
    }

    /**
     * @param UserInterface $user
     * @param string $groupName
     * @return bool
     */
    public function isInGroupName(UserInterface $user, $groupName)
    {
        $group = $this->groups->getByName($groupName);

        if ($group) {
            return $this->isInGroup($user, $group);
        }

        return false;
    }

    /**
     * @param UserInterface $user
     * @param GroupInterface $group
     */
    public function remove(UserInterface $user, GroupInterface $group)
    {
        $userGroup = Group::where('user_id', $user->getId())->where('group_id', $group->getId())->first();
        $userGroup->delete();
    }
}