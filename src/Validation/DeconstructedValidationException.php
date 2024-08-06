<?php

declare(strict_types=1);

namespace DIJ\DeconstructedValidationMessages\Validation;

use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException as BaseValidationException;

class DeconstructedValidationException extends BaseValidationException
{
    /** @var DeconstructedValidator */
    public $validator;

    public function __construct($validator, $response = null, $errorBag = 'default')
    {
        parent::__construct($validator, $response, $errorBag);
    }

    /**
     * Create an error message summary from the validation errors.
     *
     * @param DeconstructedValidator $validator
     * @return string
     */
    protected static function summarize($validator)
    {
        $messages = Arr::flatten(Arr::map($validator->errors(), function ($attribute) {
            $messages = [];
            foreach ($attribute as $rule) {
                $messages[] = $rule['message'];
            }

            return $messages;
        }));

        if (! count($messages) || ! is_string($messages[0])) {
            return $validator->getTranslator()->get('The given data was invalid.');
        }

        $message = array_shift($messages);

        if ($count = count($messages)) {
            $pluralized = $count === 1 ? 'error' : 'errors';

            $message .= ' ' . $validator->getTranslator()->choice("(and :count more $pluralized)", $count, compact('count'));
        }

        return $message;
    }

    /**
     * Get all of the validation error messages.
     *
     * @return array<string, array<string, mixed>>
     */
    public function errors()
    {
        return $this->validator->errors();
    }
}
