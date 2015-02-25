<?php

namespace Fourum\Http\Requests\Thread;

use Fourum\Http\Requests\Request;
use Fourum\Validation\ValidatorInterface;
use Illuminate\Auth\Guard;

class CreateThreadRequest extends Request
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
        return $this->container->make('validators')->get('thread');
    }
}