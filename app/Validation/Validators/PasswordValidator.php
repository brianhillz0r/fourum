<?php

namespace Fourum\Validation\Validators;

use Fourum\Validation\ValidatorInterface;
use Respect\Validation\Validator;

class PasswordValidator implements ValidatorInterface
{
    /**
     * @var array
     */
    protected $messages;

    /**
     * @param string $value
     * @return boolean
     */
    public function validate($value)
    {
        $validator = Validator::string()->length(6, null)->notEmpty();

        try {
            $validator->assert($value);
        } catch (\InvalidArgumentException $e) {
            $this->messages = $e->findMessages($this->getCustomMessages());
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        foreach ($this->messages as $message) {
            if (! empty($message)) {
                return $message;
            }
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'password';
    }

    /**
     * @return array
     */
    protected function getCustomMessages()
    {
        return array(
            'length' => 'Your password must be at least 6 characters long.',
            'notEmpty' => 'Your password must not be empty.'
        );
    }
}
