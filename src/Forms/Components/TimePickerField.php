<?php

namespace HusamTariq\FilamentTimePicker\Forms\Components;

use Filament\Forms\Components\Field;

class TimePickerField extends Field
{
    protected string $view = 'filament-timepicker::components.time-picker-field';

    protected string $okLabel = 'Ok';

    protected string $cancelLabel = 'Cancel';

    protected string $format = 'h:mm tt';

    protected bool $is24hour = false;

    /**
     * Storage format used for hydrate/dehydrate when the BD column is 24h.
     * Set to null to keep raw plugin output (display format).
     */
    protected ?string $storageFormat = 'H:i';

    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(function ($state) {
            if ($this->storageFormat === null || blank($state)) {
                return $state;
            }

            // Convert stored 24h value to display format expected by the plugin.
            try {
                return $this->convertTime((string) $state, $this->storageFormat, $this->phpDisplayFormat());
            } catch (\Throwable $e) {
                return $state;
            }
        });

        $this->dehydrateStateUsing(function ($state) {
            if ($this->storageFormat === null || blank($state)) {
                return $state;
            }

            // Convert plugin's display output back to 24h for storage.
            try {
                return $this->convertTime((string) $state, $this->phpDisplayFormat(), $this->storageFormat);
            } catch (\Throwable $e) {
                return $state;
            }
        });
    }

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

    public function storageFormat(?string $format): static
    {
        $this->storageFormat = $format;

        return $this;
    }

    public function getStorageFormat(): ?string
    {
        return $this->storageFormat;
    }

    /**
     * Map the mdtimepicker JS format tokens to PHP date() tokens.
     */
    protected function phpDisplayFormat(): string
    {
        // mdtimepicker tokens: h (12h no pad), hh (12h pad), H/HH (24h),
        // mm (minutes), ss (seconds), tt (AM/PM), t (am/pm)
        return strtr($this->format, [
            'HH' => 'H',
            'hh' => 'h',
            'mm' => 'i',
            'ss' => 's',
            'tt' => 'A',
            't' => 'a',
            'H' => 'G',
            'h' => 'g',
        ]);
    }

    protected function convertTime(string $value, string $fromFormat, string $toFormat): string
    {
        $dt = \DateTime::createFromFormat($fromFormat, $value);

        if ($dt === false) {
            // Try a loose parse as a fallback (handles stored H:i:s when format is H:i, etc.)
            $dt = new \DateTime($value);
        }

        return $dt->format($toFormat);
    }
}
