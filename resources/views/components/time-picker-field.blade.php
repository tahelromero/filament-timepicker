@php
    $statePath = $getStatePath();
    $isDisabled = $isDisabled();
    $config = json_encode([
        'okLabel' => $getOkLabel(),
        'cancelLabel' => $getCancelLabel(),
        'format' => $getFormat(),
        'timeFormat' => $getFormat(),
        'is24hour' => $getIs24hour(),
    ]);
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
                pluginConfig: {{ $config }},
                bootPlugin() {
                    const $input = $($refs.timePicker);
                    // Seed input with current state BEFORE init so the plugin parses it.
                    $refs.timePicker.value = this.state ?? '';
                    $input.mdtimepicker(this.pluginConfig);

                    // Sync picker → Livewire on user pick.
                    $input.on('timechanged', () => {
                        this.state = $refs.timePicker.value;
                    });
                },
                resetPlugin() {
                    const $input = $($refs.timePicker);
                    // Tear down and re-init so the picker reflects the new value.
                    try { $input.mdtimepicker('destroy'); } catch (e) {}
                    $refs.timePicker.value = this.state ?? '';
                    $input.mdtimepicker(this.pluginConfig);
                    $input.on('timechanged', () => {
                        this.state = $refs.timePicker.value;
                    });
                },
                init() {
                    this.bootPlugin();

                    // Re-init plugin if state changes externally (edit modal refill).
                    this.$watch('state', (val) => {
                        if ((val ?? '') !== $refs.timePicker.value) {
                            this.resetPlugin();
                        }
                    });
                },
            }"
            class="fi-input block w-full border-none bg-white/0 py-1.5 ps-3 pe-3 text-base text-gray-950 outline-none transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 sm:text-sm sm:leading-6 cursor-pointer"
        >
    </x-filament::input.wrapper>
</x-dynamic-component>
