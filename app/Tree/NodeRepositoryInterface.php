<?php

namespace Fourum\Tree;

use Fourum\Model\Node;

interface NodeRepositoryInterface
{
    /**
     * @param array $data
     * @return Node
     */
    public function create($data);

    /**
     * @param int $forumId
     * @return Node
     */
    public function getByForum($forumId);
}