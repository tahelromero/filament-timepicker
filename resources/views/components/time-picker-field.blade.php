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
        <input
            x-ref="timePicker"
            type="text"
            {{ $isDisabled ? 'disabled' : '' }}
            placeholder="--:--"
            x-data="{
                state: $wire.{{ $applyStateBindingModifiers("entangle('" . $statePath . "')") }},
                init() {
                    // Seed input value so the plugin parses the current state on init.
                    if (this.state) {
                        $refs.timePicker.value = this.state;
                    }

                    // Initialize the jQuery plugin (binds click → opens clock modal).
                    $($refs.timePicker).mdtimepicker({
                        okLabel: '{{ $getOkLabel() }}',
                        cancelLabel: '{{ $getCancelLabel() }}',
                        format: '{{ $getFormat() }}',
                        timeFormat: '{{ $getFormat() }}',
                        is24hour: {{ $getIs24hour() ? 'true' : 'false' }},
                    });

                    // Sync picker → Livewire state on user pick.
                    $($refs.timePicker).on('timechanged', (e) => {
                        this.state = $refs.timePicker.value;
                    });

                    // Sync Livewire state → input when refilled externally (edit modal).
                    this.$watch('state', (val) => {
                        if (val !== $refs.timePicker.value) {
                            $refs.timePicker.value = val ?? '';
                        }
                    });
                },
            }"
            class="fi-input block w-full border-none bg-white/0 py-1.5 ps-3 pe-3 text-base text-gray-950 outline-none transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 sm:text-sm sm:leading-6 cursor-pointer"
        >
    </x-filament::input.wrapper>
</x-dynamic-component>
