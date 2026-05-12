@php
    use Filament\Support\Facades\FilamentAsset;

    $statePath = $getStatePath();
    $isDisabled = $isDisabled();
    $timepickerCssUrl = FilamentAsset::getStyleHref('filament-timepicker-styles', 'husam-tariq/filament-timepicker');
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        x-data="{}"
        x-load-css="[@js($timepickerCssUrl)]"
        wire:ignore.self
    >
        <x-filament::input.wrapper
            :disabled="$isDisabled"
            :valid="! $errors->has($statePath)"
        >
            <input
                x-ref="timePicker"
                type="text"
                {{ $isDisabled ? 'disabled' : '' }}
                placeholder="--:-- ----"
                x-data="mdtimepicker($refs.timePicker, {
                    state: $wire.{{ $applyStateBindingModifiers("entangle('" . $statePath . "')") }},
                    config: {
                        okLabel: '{{ $getOkLabel() }}',
                        cancelLabel: '{{ $getCancelLabel() }}',
                    },
                })"
                x-init="init()"
                class="fi-input block w-full border-none bg-white/0 py-1.5 ps-3 pe-3 text-base text-gray-950 outline-none transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 sm:text-sm sm:leading-6 cursor-pointer"
            >
        </x-filament::input.wrapper>
    </div>
</x-dynamic-component>
