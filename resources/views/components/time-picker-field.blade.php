@php
    use Filament\Support\Facades\FilamentAsset;

    $statePath = $getStatePath();
    $jqueryUrl = FilamentAsset::getScriptSrc('filament-timepicker-jquery', 'husam-tariq/filament-timepicker');
    $timepickerJsUrl = FilamentAsset::getScriptSrc('filament-timepicker-scripts', 'husam-tariq/filament-timepicker');
    $timepickerCssUrl = FilamentAsset::getStyleHref('filament-timepicker-styles', 'husam-tariq/filament-timepicker');
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        x-data="{}"
        x-load-css="[@js($timepickerCssUrl)]"
        x-load-js="[@js($jqueryUrl), @js($timepickerJsUrl)]"
        class="fi-fo-timepicker-wrp"
    >
        <div @class([
            'fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5',
            'focus-within:ring-2 ring-gray-950/10 dark:ring-white/20 focus-within:ring-primary-600 dark:focus-within:ring-primary-500' => ! $isDisabled() && ! $errors->has($statePath),
            'ring-danger-600 dark:ring-danger-400 focus-within:ring-danger-600 dark:focus-within:ring-danger-400' => $errors->has($statePath),
            'opacity-70' => $isDisabled(),
        ])>
            <input
                {{ $isDisabled() ? 'disabled' : '' }}
                x-ref="timePicker"
                type="time"
                x-data="mdtimepicker($refs.timePicker, {
                    state: $wire.{{ $applyStateBindingModifiers("entangle('" . $statePath . "')") }},
                    config: {
                        okLabel: '{{ $getOkLabel() }}',
                        cancelLabel: '{{ $getCancelLabel() }}',
                    },
                })"
                x-init="init()"
                {{ $applyStateBindingModifiers('wire:model') }}="{{ $statePath }}"
                class="fi-input flex-1 border-none bg-transparent py-1.5 ps-3 pe-2 text-base text-gray-950 outline-none focus:ring-0 disabled:text-gray-500 dark:text-white dark:disabled:text-gray-400 sm:text-sm sm:leading-6 time-input-picker cursor-pointer"
            >
            <span class="flex items-center pe-3 pointer-events-none text-gray-400 dark:text-gray-500">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </span>
        </div>
    </div>
</x-dynamic-component>
