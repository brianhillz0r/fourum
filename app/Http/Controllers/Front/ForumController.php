<?php

namespace Fourum\Http\Controllers\Front;

use Fourum\Forum\ForumRepositoryInterface;
use Fourum\Http\Controllers\FrontController;

class ForumController extends FrontController
{
    /**
     * @param ForumRepositoryInterface $forums
     * @param int $id
     */
    public function view(ForumRepositoryInterface $forums, $id)
    {
        $forum = $forums->get($id);
        $this->setTitle($forum->getTitle());
        return $this->render('forum.view', ['forum' => $forum]);
    }
}