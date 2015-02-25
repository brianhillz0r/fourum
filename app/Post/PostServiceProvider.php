<?php

namespace Fourum\Post;

use Fourum\Post\Eloquent\PostRepository;
use Fourum\Post\Parser\MentionParser;
use Fourum\Post\Parser\ParserCollection;
use Illuminate\Support\ServiceProvider;

class PostServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('post.parser.pre-save', function ($app) {
            return new ParserCollection([]);
        });

        $this->app->bind('post.parser.post-save', function ($app) {
            return new ParserCollection([
                $app->make(MentionParser::class)
            ]);
        });

        $this->app->bind(PostRepositoryInterface::class, function ($app) {
            return new PostRepository($app->make('post.parser.pre-save'), $app->make('post.parser.post-save'));
        });
    }
}