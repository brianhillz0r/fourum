<?php

namespace Fourum\Http\Controllers\Front;

use Fourum\Http\Controllers\FrontController;
use Fourum\Http\Requests\Post\CreatePostRequest;
use Fourum\Http\Requests\Post\EditPostRequest;
use Fourum\Post\PostRepositoryInterface;
use Fourum\Setting\Manager;
use Fourum\Thread\ThreadRepositoryInterface;

class PostController extends FrontController
{
    /**
     * @var ThreadRepositoryInterface
     */
    protected $threads;

    /**
     * @var PostRepositoryInterface
     */
    protected $posts;

    /**
     * @param Manager $settings
     * @param ThreadRepositoryInterface $threads
     * @param PostRepositoryInterface $posts
     */
    public function __construct(
        Manager $settings,
        ThreadRepositoryInterface $threads,
        PostRepositoryInterface $posts
    ) {
        parent::__construct($settings);

        $this->threads = $threads;
        $this->posts = $posts;
    }

    /**
     * @param int $threadId
     */
    public function getCreate($threadId)
    {
        return $this->render('post.create', [
            'thread' => $this->threads->get($threadId)
        ]);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function view($id)
    {
        $thread = $this->posts->get($id)->getThread();
        return redirect()->route('thread.view', [$thread->getId(), 'highlight' => $id]);
    }

    /**
     * @param CreatePostRequest $request
     * @param int $threadId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(CreatePostRequest $request, $threadId)
    {
        $thread = $this->threads->get($threadId);

        $data = [
            'user_id' => $this->getUser()->getId(),
            'thread_id' => $thread->getId(),
            'content' => $request->get('content')
        ];

        $this->posts->createAndSave($data);

        return redirect($thread->getUrl());
    }

    /**
     * @param EditPostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(EditPostRequest $request)
    {
        $post = $request->getPost();
        $post->setContent($request->get('content'));
        $this->posts->save($post);

        return redirect()->back();
    }
}
