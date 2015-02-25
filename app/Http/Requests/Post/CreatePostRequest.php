<?php

namespace Fourum\Http\Requests\Post;

use Fourum\Http\Requests\Request;
use Fourum\Validation\ValidatorInterface;
use Illuminate\Contracts\Auth\Guard;

class CreatePostRequest extends Request
{
    /**
     * @param Guard $auth
     * @return bool
     */
    public function authorize(Guard $auth)
    {
        return ! $auth->guest();
    }

    /**
     * @return ValidatorInterface
     */
    protected function getValidator()
    {
        return $this->container->make('validators')->get('post');
    }
}