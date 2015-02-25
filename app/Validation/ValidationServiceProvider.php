<?php

namespace Fourum\Validation;

use Fourum\Validation\Validators\ContentValidator;
use Fourum\Validation\Validators\EmailValidator;
use Fourum\Validation\Validators\PasswordValidator;
use Fourum\Validation\Validators\PostValidator;
use Fourum\Validation\Validators\TitleValidator;
use Fourum\Validation\Validators\ThreadValidator;
use Fourum\Validation\Validators\UserValidator;
use Fourum\Validation\Validators\UsernameValidator;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Fourum\Validation\ValidatorRegistry', function() {
            $postRegistry = new ValidatorRegistry();
            $postRegistry->add(new ContentValidator());

            $threadRegistry = new ValidatorRegistry();
            $threadRegistry->add(new TitleValidator());
            $threadRegistry->add(new ContentValidator());;

            $userRegistry = new ValidatorRegistry();
            $userRegistry->add(new UsernameValidator());
            $userRegistry->add(new EmailValidator());
            $userRegistry->add(new PasswordValidator());

            $registry = new ValidatorRegistry();
            $registry->add(new PostValidator($postRegistry));
            $registry->add(new ThreadValidator($threadRegistry));
            $registry->add(new UserValidator($userRegistry));

            return $registry;
        });
        $this->app->alias('Fourum\Validation\ValidatorRegistry', 'validators');
    }
}
