<?php

namespace Fourum\Http\Controllers\Front;

use Fourum\Forum\ForumRepositoryInterface;
use Fourum\Http\Controllers\FrontController;
use Fourum\Http\Requests\Thread\CreateThreadRequest;
use Fourum\Menu\SimpleMenu;
use Fourum\Permission\Checker\CheckerInterface;
use Fourum\Post\PostRepositoryInterface;
use Fourum\Post\PostWithMenu;
use Fourum\Post\PostWithReportedCount;
use Fourum\Reporting\ReportRepositoryInterface;
use Fourum\Setting\Manager;
use Fourum\Thread\ThreadRepositoryInterface;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class ThreadController extends FrontController
{
    /**
     * @var ThreadRepositoryInterface
     */
    protected $threads;

    /**
     * @param Manager $settings
     * @param ThreadRepositoryInterface $threads
     */
    public function __construct(
        Manager $settings,
        ThreadRepositoryInterface $threads
    ) {
        parent::__construct($settings);

        $this->threads = $threads;
    }

    /**
     * @param Guard $auth
     * @param ReportRepositoryInterface $reports
     * @param Request $request
     * @param int $id
     */
    public function view(Guard $auth, ReportRepositoryInterface $reports, Request $request, $id)
    {
        $thread = $this->threads->get($id);
        $posts = $thread->getPosts();
        $user = $this->getUser();

        foreach ($posts as $post) {
            $postMenu = new SimpleMenu();

            if ($auth->check()) {
                Event::fire('post.menu.created', [$postMenu, $user, $post]);
            }

            // decoration
            $decoratedPost = new PostWithMenu($post, $postMenu);
            $decoratedPost = new PostWithReportedCount($decoratedPost, $reports);

            $data['posts'][] = $decoratedPost;
        }

        $data['thread'] = $thread;
        $data['forum'] = $thread->getForum();
        $data['highlight'] = $request->get('highlight');

        return $this->render('thread.view', $data);
    }

    /**
     * @param ForumRepositoryInterface $forums
     * @param int $forumId
     */
    public function getCreate(ForumRepositoryInterface $forums, $forumId)
    {
        return $this->render('thread.create', ['forum' => $forums->get($forumId)]);
    }

    /**
     * @param CreateThreadRequest $request
     * @param PostRepositoryInterface $posts
     * @param int $forumId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postCreate(CreateThreadRequest $request, PostRepositoryInterface $posts, $forumId)
    {
        $thread = $this->threads->createAndSave([
            'title' => $request->get('title'),
            'user_id' => $this->getUser()->getId(),
            'forum_id' => $forumId
        ]);

        $posts->createAndSave([
            'content' => $request->get('content'),
            'user_id' => $this->getUser()->getId(),
            'thread_id' => $thread->getId()
        ]);

        return redirect($thread->getUrl());
    }
}
