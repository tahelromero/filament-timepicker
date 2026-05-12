@php
    $statePath = $getStatePath();
    $isDisabled = $isDisabled();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <x-filament::input.wrapper
        :disabled="$isDisabled"
        :valid="! $errors->has($statePath)"
        suffix-icon="heroicon-m-clock"
    >
        <x-filament::input
            type="time"
            :disabled="$isDisabled"
            :wire:model="$statePath"
        />
    </x-filament::input.wrapper>
</x-dynamic-component>
