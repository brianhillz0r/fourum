<?php

namespace Fourum\Validation;

class ValidatorRegistry
{
    /**
     * @var array
     */
    protected $validators;

    /**
     * @param array $validators
     */
    public function __construct(array $validators = [])
    {
        $this->validators = $validators;
    }

    /**
     * @param ValidatorInterface $validator
     */
    public function add(ValidatorInterface $validator)
    {
        $this->validators[$validator->getName()] = $validator;
    }

    /**
     * @param string $name
     * @return ValidatorInterface
     */
    public function get($name)
    {
        return array_key_exists($name, $this->validators) ? $this->validators[$name] : null;
    }
}
