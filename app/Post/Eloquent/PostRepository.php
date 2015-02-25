<?php

namespace Fourum\Post\Eloquent;

use Fourum\Model\Post;
use Fourum\Post\Parser\ParserInterface;
use Fourum\Post\PostInterface;
use Fourum\Post\PostRepositoryInterface;
use Illuminate\Support\Collection;

class PostRepository implements PostRepositoryInterface
{
    /**
     * @var ParserInterface
     */
    protected $preSaveParser;

    /**
     * @var ParserInterface
     */
    protected $postSaveParser;

    /**
     * @param ParserInterface $preSaveParser
     * @param ParserInterface $postSaveParser
     */
    public function __construct(ParserInterface $preSaveParser, ParserInterface $postSaveParser)
    {
        $this->preSaveParser = $preSaveParser;
        $this->postSaveParser = $postSaveParser;
    }

    /**
     * @return Collection
     */
    public function getAll()
    {
        return Post::all();
    }

    /**
     * @param int $id
     * @return Post
     */
    public function get($id)
    {
        return Post::find($id);
    }

    /**
     * @param array $input
     * @return Post
     */
    public function createAndSave(array $input)
    {
        $post = $this->create($input);
        $this->save($post);
        return $post;
    }

    /**
     * @param array $input
     * @return Post
     */
    public function create(array $input)
    {
        $post = new Post($input);
        return $this->preSaveParser->parse($post);
    }

    /**
     * @param PostInterface $post
     * @return PostInterface
     */
    public function save(PostInterface $post)
    {
        $post->save();
        $post = $this->postSaveParser->parse($post);
        $post->save();
        return $post;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'post';
    }
}