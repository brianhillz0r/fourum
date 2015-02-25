<?php

namespace Fourum\Validation\Validators;

use Fourum\Validation\ValidatorInterface;
use Illuminate\Support\Facades\DB;
use Respect\Validation\Validator;

class UsernameValidator implements ValidatorInterface
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
        $validator = Validator::alnum()->notEmpty()->noWhitespace()->callback(function ($input) {
            $count = (int) DB::table('users')->where('username', '=', $input)->count();

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
        return 'username';
    }

    /**
     * @return array
     */
    protected function getCustomMessages()
    {
        return array(
            'notEmpty' => 'Your username cannot be empty.',
            'noWhitespace' => 'Your username must not contain any spaces.',
            'alnum' => 'Your username must only contain alphanumeric characters.',
            'callback' => 'That username is already taken.'
        );
    }
}
