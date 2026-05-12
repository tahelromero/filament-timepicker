@php
    use Filament\Support\Facades\FilamentAsset;

    $statePath = $getStatePath();
    $isDisabled = $isDisabled();
    $jqueryUrl = FilamentAsset::getScriptSrc('filament-timepicker-jquery', 'husam-tariq/filament-timepicker');
    $timepickerJsUrl = FilamentAsset::getScriptSrc('filament-timepicker-scripts', 'husam-tariq/filament-timepicker');
    $timepickerCssUrl = FilamentAsset::getStyleHref('filament-timepicker-styles', 'husam-tariq/filament-timepicker');
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        x-data="{}"
        x-load-css="[@js($timepickerCssUrl)]"
        x-load-js="[@js($jqueryUrl), @js($timepickerJsUrl)]"
        wire:ignore.self
    >
        <x-filament::input.wrapper
            :disabled="$isDisabled"
            :valid="! $errors->has($statePath)"
            suffix-icon="heroicon-m-clock"
        >
            <x-filament::input
                x-ref="timePicker"
                type="time"
                :disabled="$isDisabled"
                :wire:model="$applyStateBindingModifiers('wire:model') ? $statePath : null"
                x-data="mdtimepicker($refs.timePicker, {
                    state: $wire.{{ $applyStateBindingModifiers("entangle('" . $statePath . "')") }},
                    config: {
                        okLabel: '{{ $getOkLabel() }}',
                        cancelLabel: '{{ $getCancelLabel() }}',
                    },
                })"
                x-init="init()"
                class="time-input-picker cursor-pointer"
            />
        </x-filament::input.wrapper>
    </div>
</x-dynamic-component>
