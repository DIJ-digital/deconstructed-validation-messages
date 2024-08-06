<?php

declare(strict_types=1);

namespace DIJ\DeconstructedValidationMessages\Validation;

use Illuminate\Support\Str;

class ErrorStore
{
    /** @var array<string, array<string, mixed>> */
    private array $errors = [];

    public function addError(string $attribute, string $rule, string $key): void
    {
        $this->errors[$attribute][Str::lower($rule)] = ['key' => $key];
    }

    /**
     * @param array<int, bool|float|int|string> $parameters
     */
    public function addParametersToError(string $attribute, string $rule, array $parameters): void
    {
        $key = $this->errors[$attribute][Str::lower($rule)]['key'];

        $errorParams = [];

        $debris = explode(' ', __($key, ['attribute' => $attribute]));
        $i = 0;
        foreach ($debris as $particle) {
            if (Str::startsWith($particle, ':')) {
                $particle = ltrim($particle, ':');

                $errorParams[$particle] = $parameters[$i];

                $i++;
            }
        }

        $message = __($key, ['attribute' => $attribute] + $errorParams);

        $this->errors[$attribute][Str::lower($rule)]['message'] = $message;
        $this->errors[$attribute][Str::lower($rule)]['parameters'] = ['attribute' => $attribute] + $errorParams;
    }

    public function hasError(string $attribute, string $rule): bool
    {
        return isset($this->errors[$attribute][Str::lower($rule)]);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
