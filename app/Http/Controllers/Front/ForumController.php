<?php

namespace Fourum\Http\Controllers\Front;

use Fourum\Forum\ForumRepositoryInterface;
use Fourum\Http\Controllers\FrontController;

class ForumController extends FrontController
{
    /**
     * @param ForumRepositoryInterface $forum
     * @param int $id
     */
    public function view(ForumRepositoryInterface $forum, $id)
    {
        return $this->render('forum.view', ['forum' => $forum->get($id)]);
    }
}