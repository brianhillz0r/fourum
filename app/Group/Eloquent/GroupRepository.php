<?php

namespace Fourum\Group\Eloquent;

use Fourum\Group\GroupInterface;
use Fourum\Group\GroupRepositoryInterface;
use Fourum\Model\Group;

class GroupRepository implements GroupRepositoryInterface
{
    /**
     * @param string $name
     * @return GroupInterface
     */
    public function getByName($name)
    {
        return Group::where('name', '=', $name)->first();
    }

    /**
     * @param int $id
     * @return GroupInterface
     */
    public function get($id)
    {
        return Group::find($id);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return Group::all();
    }

    /**
     * @param array $input
     * @return GroupInterface
     */
    public function createAndSave(array $input)
    {
        return Group::create($input);
    }
}