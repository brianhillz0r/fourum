<?php

namespace Fourum\Post\Parser;

use Fourum\Post\PostInterface;

class ParserCollection implements ParserInterface
{
    /**
     * @var array
     */
    protected $parsers = [];

    /**
     * @param array $parsers
     */
    public function __construct(array $parsers)
    {
        foreach ($parsers as $parser) {
            $this->addParser($parser);
        }
    }

    /**
     * @param ParserInterface $parser
     */
    public function addParser(ParserInterface $parser)
    {
        $this->parsers[] = $parser;
    }

    /**
     * @param PostInterface $post
     * @return PostInterface
     */
    public function parse(PostInterface $post)
    {
        foreach ($this->parsers as $parser) {
            if ($parser->supports($post)) {
                $parser->parse($post);
            }
        }

        return $post;
    }

    /**
     * @param PostInterface $post
     * @return bool
     */
    public function supports(PostInterface $post)
    {
        return true;
    }
}