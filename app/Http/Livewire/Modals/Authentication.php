<?php

namespace App\Http\Livewire\Modals;

use App\Models\LoginAttemp;
use App\Services\LoginService;
use LivewireUI\Modal\ModalComponent;
use App\Services\ScoreEngineService;
use Illuminate\Validation\Rules\Password;

class Authentication extends ModalComponent
{
    public string $action = 'login';
    public ?string $name = null;
    public ?string $surname = null;
    public string $email = '';
    public ?string $password = null;
    public ?string $password_confirmation = null;
    public ?array $loginScoreResponse = null;

    public function updated($propertyName): void
    {
        if ($this->action === 'register') {
            $this->validateOnly($propertyName, [
                'name' => 'required|string',
                'surname' => 'required|string',
                'email' => 'required|email',
                'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->uncompromised()],
                'password_confirmation' => 'required|same:password'
            ]);
        } else {
            if ($this->action === 'forgottenPassword') {
                $this->validateOnly($propertyName, [
                    'email' => 'required|email',
                ]);
            } else {
                $this->validateOnly($propertyName, [
                    'email' => 'required|email',
                    'password' => 'required|string'
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.modals.authentication');
    }

    public function switchTo(string $action): void
    {
        $this->action = in_array($action, ['login', 'register', 'forgottenPassword'], true) ? $action : 'login';
    }

    public function submit(): void
    {
        $this->loginScoreResponse = null;
        if ($this->action === 'register') {
            $validated = $this->validate([
                'name' => 'required|string',
                'surname' => 'required|string',
                'email' => 'required|email',
                'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()],
                'password_confirmation' => 'required|same:password'
            ]);
        } else {
            if ($this->action === 'forgottenPassword') {
                $validated = $this->validate([
                    'email' => 'required|email',
                ]);
            } else {
                $validated = $this->validate([
                    'email' => 'required|email|exists:users,email',
                    'password' => 'required|string'
                ]);
                $scoreEngineService = new ScoreEngineService();
                $this->loginScoreResponse = $scoreEngineService->score(request(), $validated);
            }
        }
    }
}

