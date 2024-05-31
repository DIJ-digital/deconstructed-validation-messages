<?php

declare(strict_types=1);

namespace DIJ\DeconstructedValidationMessages;

use DIJ\DeconstructedValidationMessages\Validation\DeconstructedValidator;
use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DeconstructedValidationMessagesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('deconstructed-validation-messages')
            ->hasConfigFile();
    }

    public function boot(): void
    {
        App::make('validator')->resolver(fn ($translator, $data, $rules, $messages) => new DeconstructedValidator($translator, $data, $rules, $messages));
    }
}
