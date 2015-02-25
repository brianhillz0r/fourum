<?php

namespace Fourum\Post;

use Fourum\Model\Thread;
use Fourum\User\UserInterface;

interface PostInterface
{
    /**
     * @return Thread
     */
    public function getThread();

    /**
     * @param string $content
     */
    public function setContent($content);

    /**
     * @param UserInterface $user
     * @return bool
     */
    public function isAuthor(UserInterface $user);
}