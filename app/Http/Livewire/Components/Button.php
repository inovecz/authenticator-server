<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use App\Enums\ButtonStyle;

class Button extends Component
{
    public string $title = ':title';
    public string $awesomeIcon;
    public string $style = 'primary';
    public string $type = 'button';
    public ?string $click = null;

    private ButtonStyle $buttonStyle;

    public function mount()
    {
        $this->type = !in_array($this->type, ['button', 'submit', 'reset'], true) ? 'button' : $this->type;
        $this->buttonStyle = ButtonStyle::tryfrom($this->style) ?: ButtonStyle::PRIMARY;
    }

    public function render()
    {
        return view('livewire.components.button', ['buttonStyle' => $this->buttonStyle]);
    }
}
