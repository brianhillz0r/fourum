<?php

namespace Fourum\Validation\Validators;

use Fourum\Validation\ValidatorInterface;

class NullValidator implements ValidatorInterface
{
    /**
     * @param mixed $value
     * @return bool
     */
    public function validate($value)
    {
        return true;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}