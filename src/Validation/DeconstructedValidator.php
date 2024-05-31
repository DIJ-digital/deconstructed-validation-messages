<?php

declare(strict_types=1);

namespace DIJ\DeconstructedValidationMessages\Validation;

use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;

class DeconstructedValidator extends Validator
{
    private readonly ErrorStore $errorStore;

    /**
     * @param  array<string, mixed>  $data
     * @param  array<int, mixed>  $rules
     * @param  array<string, mixed>  $messages
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(Translator $translator, array $data, array $rules, array $messages = [], array $attributes = [])
    {
        parent::__construct($translator, $data, $rules, $messages, $attributes);

        $this->errorStore = new ErrorStore();
    }

    /**
     * @return MessageBag|array<string, array<string, mixed>>
     */
    public function errors(): MessageBag|array
    {
        return $this->errorStore->getErrors();
    }

    protected function getMessage($attribute, $rule): string
    {
        $attributeWithPlaceholders = $attribute;

        $attribute = $this->replacePlaceholderInString($attribute);

        $inlineMessage = $this->getInlineMessage($attribute, $rule);

        // First we will retrieve the custom message for the validation rule if one
        // exists. If a custom validation message is being used we'll return the
        // custom message, otherwise we'll keep searching for a valid message.
        if (! is_null($inlineMessage)) {
            return $inlineMessage;
        }

        $lowerRule = Str::snake($rule);

        $customKey = "validation.custom.{$attribute}.{$lowerRule}";

        $customMessage = $this->getCustomMessageFromTranslator(
            in_array($rule, $this->sizeRules)
                ? [$customKey . ".{$this->getAttributeType($attribute)}", $customKey]
                : $customKey
        );

        // First we check for a custom defined validation message for the attribute
        // and rule. This allows the developer to specify specific messages for
        // only some attributes and rules that need to get specially formed.
        if ($customMessage !== $customKey) {
            $this->errorStore->addError($attribute, $rule, $customKey);

            return $customMessage;
        }

        // If the rule being validated is a "size" rule, we will need to gather the
        // specific error message for the type of attribute being validated such
        // as a number, file or string which all have different message types.
        elseif (in_array($rule, $this->sizeRules)) {
            return $this->getSizeMessage($attributeWithPlaceholders, $rule);
        }

        // Finally, if no developer specified messages have been set, and no other
        // special messages apply for this rule, we will just pull the default
        // messages out of the translator service for this validation rule.
        $key = "validation.{$lowerRule}";

        if ($key !== ($value = $this->translator->get($key))) {
            $this->errorStore->addError($attribute, $rule, $key);

            return $value;
        }

        return $this->getFromLocalArray(
            $attribute, $lowerRule, $this->fallbackMessages
        ) ?: $key;
    }

    protected function getSizeMessage($attribute, $rule)
    {
        $lowerRule = Str::snake($rule);

        // There are three different types of size validations. The attribute may be
        // either a number, file, or string so we will check a few things to know
        // which type of value it is and return the correct line for that type.
        $type = $this->getAttributeType($attribute);

        $key = "validation.{$lowerRule}.{$type}";

        $this->errorStore->addError($attribute, $rule, $key);

        return $this->translator->get($key);
    }

    /**
     * @param  array<int, bool|float|int|string>  $parameters
     */
    public function makeReplacements($message, $attribute, $rule, $parameters): string
    {
        if (! $this->errorStore->hasError($attribute, $rule)) {
            $this->errorStore->addError($attribute, $rule, $message);
        }

        $this->errorStore->addParametersToError($attribute, $rule, $parameters);

        return parent::makeReplacements($message, $attribute, $rule, $parameters);
    }
}
