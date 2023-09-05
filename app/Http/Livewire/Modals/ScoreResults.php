<?php

namespace App\Http\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;

class ScoreResults extends ModalComponent
{
    public array $response;

    public function mount(array $response)
    {
        $this->response = $response;
    }

    public function render()
    {
        return view('livewire.modals.score-results');
    }

    public function cancel(): void
    {
        $this->closeModal();
    }
}
