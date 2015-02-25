<?php namespace Fourum\Http\Requests;

use Fourum\Validation\ValidatorInterface;
use Fourum\Validation\Validators\NullValidator;
use Illuminate\Contracts\Support\MessageProvider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exception\HttpResponseException;

abstract class Request extends FormRequest
{
    public function validate()
    {
        $validator = $this->getValidator();
        if (! $this->passesAuthorization()) {
            $this->failedAuthorization();
        } elseif (! $validator->validate($this->all())) {
            $this->failValidation($validator);
        }
    }

    /**
     * @return ValidatorInterface|MessageProvider
     */
    protected function getValidator()
    {
        return new NullValidator();
    }

    /**
     * @param MessageProvider $validator
     */
    protected function failValidation(MessageProvider $validator)
    {
        throw new HttpResponseException($this->response(
            $validator->getMessageBag()->all()
        ));
    }
}
