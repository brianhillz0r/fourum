<?php

namespace Fourum\Post;

use Fourum\Repository\RepositoryInterface;

interface PostRepositoryInterface extends RepositoryInterface
{
    /**
     * @param PostInterface $post
     * @return PostInterface
     */
    public function save(PostInterface $post);
}