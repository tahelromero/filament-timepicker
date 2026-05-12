<?php

namespace HusamTariq\FilamentTimePicker;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentTimePickerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-timepicker')
            ->hasViews()
            ->hasConfigFile();
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            // All assets load globally inside Filament panels (~52KB total).
            // Avoids Alpine x-data evaluating before lazy assets finish loading.
            Js::make('filament-timepicker-jquery', config('filament-timepicker.jquery_min', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js')),
            Js::make('filament-timepicker-scripts', __DIR__.'/../public/dist/timepicker.js'),
            Css::make('filament-timepicker-styles', __DIR__.'/../public/dist/timepicker.min.css'),
        ], package: 'husam-tariq/filament-timepicker');
    }
}
