<?php

declare(strict_types=1);

namespace DIJ\DeconstructedValidationMessages;

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
}
