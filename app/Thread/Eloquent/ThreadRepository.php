<?php

namespace Fourum\Thread\Eloquent;

use Fourum\Model\Thread;
use Fourum\Thread\ThreadInterface;
use Fourum\Thread\ThreadRepositoryInterface;
use Illuminate\Support\Collection;

class ThreadRepository implements ThreadRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll()
    {
        return Thread::all();
    }

    /**
     * @param int $id
     * @return ThreadInterface
     */
    public function get($id)
    {
        return Thread::find($id);
    }

    /**
     * @param array $input
     * @return ThreadInterface
     */
    public function createAndSave(array $input)
    {
        return Thread::create($input);
    }

    /**
     * @param array $input
     * @return Thread
     */
    public function create(array $input)
    {
        return new Thread($input);
    }
}