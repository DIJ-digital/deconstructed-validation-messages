<?php
declare(strict_types=1);


namespace DIJ\DeconstructedValidationMessages\Http\Requests;

use DIJ\DeconstructedValidationMessages\Validation\DeconstructedValidator;
use DIJ\DeconstructedValidationMessages\Validation\DeconstructedValidatorFactory;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeconstructedFormRequest extends BaseFormRequest
{
    /**
     * @param DeconstructedValidator $validator
     */
    protected function failedValidation($validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()));
    }

    protected function getValidatorInstance()
    {
        /** @phpstan-ignore-next-line  */
        if ($this->validator) {
            return $this->validator;
        }

        /** @phpstan-ignore-next-line  */
        $factory = $this->container->make(DeconstructedValidatorFactory::class);

        if (method_exists($this, 'validator')) {
            $validator = $this->container->call([$this, 'validator'], compact('factory'));
        } else {
            $validator = $this->createDefaultValidator($factory);
        }

        if (method_exists($this, 'withValidator')) {
            $this->withValidator($validator);
        }

        if (method_exists($this, 'after')) {
            $validator->after($this->container->call(
                $this->after(...),
                ['validator' => $validator]
            ));
        }

        $this->setValidator($validator);

        return $this->validator;
    }
}
