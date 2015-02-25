<?php

namespace Fourum\Forum\Eloquent;

use Fourum\Forum\ForumInterface;
use Fourum\Forum\ForumRepositoryInterface;
use Fourum\Model\Forum;

class ForumRepository implements ForumRepositoryInterface
{
    /**
     * @return array
     */
    public function getAll()
    {
        return Forum::all();
    }

    /**
     * @param array $input
     * @return ForumInterface
     */
    public function createAndSave(array $input)
    {
        return Forum::create($input);
    }

    /**
     * @param int $id
     * @return ForumInterface
     */
    public function get($id)
    {
        return Forum::find($id);
    }
}