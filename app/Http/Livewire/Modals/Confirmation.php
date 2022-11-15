<?php

namespace App\Http\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;

class Confirmation extends ModalComponent
{
    public string $type;
    public string $title;
    public string $text;
    public string $event;
    public array $passThrough;

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function mount(string $type = 'info', string $title = 'Titulek', string $text = 'Popis', string $event = 'confirmed', array $passThrough = []): void
    {
        $this->type = $type;
        $this->title = $title;
        $this->text = $text;
        $this->event = $event;
        $this->passThrough = $passThrough;
    }

    public function render()
    {
        return view('livewire.modals.confirmation');
    }

    public function cancel(): void
    {
        $this->closeModal();
    }

    public function process(): void
    {
        $this->emit($this->event, $this->passThrough);
        $this->closeModal();
    }

}
