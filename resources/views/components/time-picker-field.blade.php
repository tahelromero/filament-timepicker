@php
    $statePath = $getStatePath();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div class="relative flex items-center justify-start">
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
            @class([
                'time-input-picker fi-input block w-full border-none bg-white/0 py-1.5 text-base text-gray-950 outline-none transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 ps-3 pe-10 relative cursor-default rounded-lg shadow-sm ring-1 ring-inset',
                'focus-within:ring-2 focus-within:ring-primary-600 dark:focus-within:ring-primary-500' => !$isDisabled(),
                'ring-gray-300 dark:ring-white/10 bg-white dark:bg-white/5' => !$errors->has($statePath),
                'ring-danger-600 dark:ring-danger-500' => $errors->has($statePath),
                'opacity-70' => $isDisabled(),
            ])
        >
        <span class="absolute inset-y-0 end-0 flex items-center pe-2 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </span>
    </div>
</x-dynamic-component>
