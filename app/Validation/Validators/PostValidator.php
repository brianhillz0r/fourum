<?php

namespace Fourum\Validation\Validators;

use Fourum\Validation\ValidatorInterface;
use Fourum\Validation\ValidatorRegistry;
use Illuminate\Contracts\Support\MessageProvider;
use Illuminate\Support\MessageBag;

class PostValidator implements ValidatorInterface, MessageProvider
{
    /**
     * @var \Fourum\Validation\ValidatorRegistry
     */
    protected $validators;

    /**
     * @var array
     */
    protected $messages;

    /**
     * @param \Fourum\Validation\ValidatorRegistry $registry
     */
    public function __construct(ValidatorRegistry $registry)
    {
        $this->validators = $registry;
        $this->messages = array();
    }

    /**
     * @param array $value
     * @return boolean
     */
    public function validate($value)
    {
        foreach ($value as $validatorName => $val) {
            $validator = $this->getValidator($validatorName);

            if ($validator && ! $validator->validate($val)) {
                $this->messages[$validator->getName()] = $validator->getMessage();
            }
        }

        return count($this->messages) === 0;
    }

    /**
     * @return array
     */
    public function getMessage()
    {
        return $this->messages;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'post';
    }

    /**
     * @return \Illuminate\Support\MessageBag
     */
    public function getMessageBag()
    {
        return new MessageBag($this->messages);
    }

    /**
     * @param string $name
     * @return ValidatorInterface
     * @throws \Exception
     */
    protected function getValidator($name)
    {
        $validator = $this->validators->get($name);
        return $validator;
    }
}
