<?php

namespace App\Http\Livewire\Modals;

use App\Models\User;
use App\Events\Enforce2FAEvent;
use Elegant\Sanitizer\Sanitizer;
use LivewireUI\Modal\ModalComponent;
use App\Services\ScoreEngineService;
use Illuminate\Validation\Rules\Password;
use App\Services\VerificationCodeService;

class Authentication extends ModalComponent
{
    public string $action = 'login';
    public ?string $name = null;
    public ?string $surname = null;
    public string $email = '';
    public ?string $password = null;
    public ?string $verification_code = null;
    public ?string $password_confirmation = null;
    public ?array $loginScoreResponse = null;
    public bool $twoFactorRequired = false;

    public ?int $loginAttemptId = null;

    public function updated($propertyName): void
    {
        if ($this->action === 'register') {
            $this->validateOnly($propertyName, [
                'name' => 'required|string',
                'surname' => 'required|string',
                'email' => 'required|email',
                'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->uncompromised()],
                'password_confirmation' => 'required|same:password',
            ]);
        } elseif ($this->action === 'forgottenPassword') {
            $this->validateOnly($propertyName, [
                'email' => 'required|email',
            ]);
        } else {
            $this->validateOnly($propertyName, [
                'email' => 'required|email',
                'password' => 'required|string',
            ]);
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
                'password_confirmation' => 'required|same:password',
            ]);
        } elseif ($this->action === 'forgottenPassword') {
            $validated = $this->validate([
                'email' => 'required|email',
            ]);
        } else {
            $validated = $this->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required|string',
                'verification_code' => $this->twoFactorRequired ? 'required|string' : 'nullable',
            ]);

            $filters = [
                'email' => 'trim|escape',
                'password' => 'trim|escape',
                'verification_code' => 'trim|escape',
            ];

            $sanitized = (new Sanitizer($validated, $filters))->sanitize();

            $user = User::where('email', $validated['email'])->first();

            if ($this->twoFactorRequired) {
                $verificationCodeService = new VerificationCodeService();
                $verified = $verificationCodeService->verifyCode($user, $sanitized['verification_code']);
                if ($verified) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Ověření bylo úspěšné', 'options' => ['timeOut' => 1000]]);
                    $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => 'Přihlášení může pokračovat...', 'options' => ['timeOut' => 5000]]);
                    $this->confirmLoginAttempt($this->loginAttemptId);
                } else {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Zadaný kód neodpovídá nebo jeho platnost již vypršela', 'options' => ['timeOut' => 5000]]);
                    return;
                }
            }
            $scoreEngineService = new ScoreEngineService();
            $this->loginScoreResponse = $scoreEngineService->score(request(), $validated);
            if (isset($this->loginScoreResponse['login_attempt_id'])) {
                $this->loginAttemptId = $this->loginScoreResponse['login_attempt_id'];
            }
            if (isset($this->loginScoreResponse['error']) && $this->loginScoreResponse['error'] === 'Entity is blacklisted') {
                $reason = match ($this->loginScoreResponse['blacklist_type']) {
                    'IP' => 'zakázané IP adresy',
                    'DOMAIN' => 'zakázané domény',
                    'EMAIL' => 'zakázaného e-mailu',
                };
                $this->addError('scoring_engine', 'Přihlášení z Vašeho účtu je blokováno z důvodu '.$reason.'.');
            } else {

                $settings = $scoreEngineService->fetchSettings();
                $twoFactorTresshold = $settings['scoring']['twofactor_when_score_gte'] ?? config('inove.login.enforce_twofactor_default_tresshold');
                $disallowTresshold = $settings['scoring']['disallow_when_score_gte'] ?? config('inove.login.disallow_default_tresshold');
                if (!$this->twoFactorRequired && isset($this->loginScoreResponse['score']) && $this->loginScoreResponse['score'] >= $twoFactorTresshold && $this->loginScoreResponse['score'] < $disallowTresshold) {
                    Enforce2FAEvent::dispatch($user);
                    $this->twoFactorRequired = true;
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => 'Pro pokračování je potřeba zadat ověřovací kód', 'options' => ['timeOut' => 5000]]);
                    $this->addError('verification_code', 'Pro ověření zadejte kód, který byl odeslán na Váš e-mail.');
                } else {
                    $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => 'Přihlášení může pokračovat...', 'options' => ['timeOut' => 5000]]);
                    $this->confirmLoginAttempt($this->loginAttemptId);
                }

                if (isset($this->loginScoreResponse['score']) && $this->loginScoreResponse['score'] >= $disallowTresshold) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Skóre větší než '.$disallowTresshold.', přihlášení je blokováno', 'options' => ['timeOut' => 5000]]);
                }
            }
        }
    }

    private function confirmLoginAttempt(int $loginAttemptId): void
    {
        $scoringEngineService = new ScoreEngineService();
        $scoringEngineService->confirmLoginAttempt($loginAttemptId);
    }
}

