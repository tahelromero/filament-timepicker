<?php

namespace HusamTariq\FilamentTimePicker\Forms\Components;

use Filament\Forms\Components\Field;

class TimePickerField extends Field
{
    protected string $view = 'filament-timepicker::components.time-picker-field';

    protected string $okLabel = 'Ok';

    protected string $cancelLabel = 'Cancel';

    protected string $format = 'HH:mm';

    protected bool $is24hour = true;

    public function cancelLabel(string $cancelLabel): static
    {
        $this->cancelLabel = $cancelLabel;

        return $this;
    }

    public function getCancelLabel(): string
    {
        return $this->cancelLabel;
    }

    public function okLabel(string $okLabel): static
    {
        $this->okLabel = $okLabel;

        return $this;
    }

    public function getOkLabel(): string
    {
        return $this->okLabel;
    }

    public function format(string $format): static
    {
        $this->format = $format;

        return $this;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function is24hour(bool $value = true): static
    {
        $this->is24hour = $value;

        return $this;
    }

    public function getIs24hour(): bool
    {
        return $this->is24hour;
    }
}
