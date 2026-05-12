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
            // jQuery + plugin JS load globally so Alpine x-data="mdtimepicker(...)"
            // can resolve immediately on render. Total ~42KB inside Filament panels only.
            Js::make('filament-timepicker-jquery', config('filament-timepicker.jquery_min', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js')),
            Js::make('filament-timepicker-scripts', __DIR__.'/../public/dist/timepicker.js'),

            // CSS is heavier — keep it lazy since it only matters when the modal opens.
            Css::make('filament-timepicker-styles', __DIR__.'/../public/dist/timepicker.min.css')
                ->loadedOnRequest(),
        ], package: 'husam-tariq/filament-timepicker');
    }
}
