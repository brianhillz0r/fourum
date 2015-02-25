<?php

namespace Fourum\Http\Requests\Post;

use Fourum\Http\Requests\Request;
use Fourum\Post\PostInterface;
use Fourum\Post\PostRepositoryInterface;
use Fourum\Validation\ValidatorInterface;

class EditPostRequest extends Request
{
    /**
     * @var PostInterface
     */
    protected $post;

    /**
     * @return bool
     */
    public function authorize()
    {
        $post = $this->getPost();
        return $post->isAuthor($this->user());
    }

    /**
     * @return PostInterface
     */
    public function getPost()
    {
        if (! $this->post) {
            $posts = $this->container->make(PostRepositoryInterface::class);
            $this->post = $posts->get($this->get('postId'));
        }

        return $this->post;
    }

    /**
     * @return ValidatorInterface
     */
    protected function getValidator()
    {
        return $this->container->make('validators')->get('post');
    }
}