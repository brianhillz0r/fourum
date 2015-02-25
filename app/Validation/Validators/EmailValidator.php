<?php

namespace Fourum\Validation\Validators;

use Fourum\Validation\ValidatorInterface;
use Illuminate\Support\Facades\DB;
use Respect\Validation\Validator;

class EmailValidator implements ValidatorInterface
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
        $validator = Validator::email()->notEmpty()->noWhitespace()->callback(function ($input) {
            $count = (int) DB::table('users')->where('email', '=', $input)->count();

            return $count === 0;
        });

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
        return 'email';
    }

    /**
     * @return array
     */
    protected function getCustomMessages()
    {
        return array(
            'notEmpty' => 'Your email address cannot be empty.',
            'noWhitespace' => 'Your email address must not contain spaces.',
            'email' => 'You must enter a valid email address.',
            'callback' => 'That email address is already registered.'
        );
    }
}
