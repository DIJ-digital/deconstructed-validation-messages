<?php

declare(strict_types=1);

namespace DIJ\DeconstructedValidationMessages\Validation;

use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;

class DeconstructedValidatorFactory extends Factory
{
    /**
     * @param  array<string, mixed>  $data
     * @param  array<int, mixed>  $rules
     * @param  array<string, mixed>  $messages
     * @param  array<string, mixed>  $attributes
     * @return DeconstructedValidator|Validator|mixed
     */
    protected function resolve(array $data, array $rules, array $messages, array $attributes)
    {
        /** @phpstan-ignore-next-line  */
        if (is_null($this->resolver)) {
            return new DeconstructedValidator($this->translator, $data, $rules, $messages, $attributes);
        }

        return call_user_func($this->resolver, $this->translator, $data, $rules, $messages, $attributes);
    }
}
