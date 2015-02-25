<?php

namespace Fourum\Validation;

interface ValidatorInterface
{
    /**
     * @param mixed $value
     * @return bool
     */
    public function validate($value);

    /**
     * @return string
     */
    public function getMessage();

    /**
     * @return string
     */
    public function getName();
}
