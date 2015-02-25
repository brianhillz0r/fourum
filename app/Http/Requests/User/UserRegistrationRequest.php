<?php

namespace Fourum\Http\Requests\User;

use Fourum\Http\Requests\Request;
use Fourum\Validation\ValidatorInterface;

class UserRegistrationRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    /**
     * @return ValidatorInterface
     */
    protected function getValidator()
    {
        return $this->container->make('validators')->get('user');
    }
}