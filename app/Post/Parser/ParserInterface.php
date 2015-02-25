<?php

namespace Fourum\Post\Parser;

use Fourum\Post\PostInterface;

interface ParserInterface
{
    /**
     * @param PostInterface $post
     * @return PostInterface
     */
    public function parse(PostInterface $post);

    /**
     * @param PostInterface $post
     * @return bool
     */
    public function supports(PostInterface $post);
}