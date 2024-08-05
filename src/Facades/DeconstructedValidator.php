<?php
declare(strict_types=1);

namespace DIJ\DeconstructedValidationMessages\Facades;

use App\Validation\TrankieValidatorFactory;
use DIJ\DeconstructedValidationMessages\Validation\DeconstructedValidatorFactory;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Validation\Validator make(array $data, array $rules, array $messages = [], array $attributes = [])
 * @method static array validate(array $data, array $rules, array $messages = [], array $attributes = [])
 * @method static void extend(string $rule, \Closure|string $extension, string|null $message = null)
 * @method static void extendImplicit(string $rule, \Closure|string $extension, string|null $message = null)
 * @method static void extendDependent(string $rule, \Closure|string $extension, string|null $message = null)
 * @method static void replacer(string $rule, \Closure|string $replacer)
 * @method static void includeUnvalidatedArrayKeys()
 * @method static void excludeUnvalidatedArrayKeys()
 * @method static void resolver(\Closure $resolver)
 * @method static \Illuminate\Contracts\Translation\Translator getTranslator()
 * @method static \Illuminate\Validation\PresenceVerifierInterface getPresenceVerifier()
 * @method static void setPresenceVerifier(\Illuminate\Validation\PresenceVerifierInterface $presenceVerifier)
 * @method static \Illuminate\Contracts\Container\Container|null getContainer()
 * @method static \Illuminate\Validation\Factory setContainer(\Illuminate\Contracts\Container\Container $container)
 *
 * @see \DIJ\DeconstructedValidationMessages\Validation\DeconstructedValidator
 */
class DeconstructedValidator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return DeconstructedValidatorFactory::class;
    }
}