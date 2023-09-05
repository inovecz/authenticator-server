<?php

namespace App\Http\Livewire\Modals;

use App\Models\User;
use App\Events\Enforce2FAEvent;
use Elegant\Sanitizer\Sanitizer;
use LivewireUI\Modal\ModalComponent;
use App\Services\ScoreEngineService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Services\VerificationCodeService;

class Authentication extends ModalComponent
{
    public float $elapsedTime = 0.0;
    public float $mouseMaxSpeed = 0.0;
    public float $mouseAvgSpeed = 0.0;
    public float $mouseMaxAccel = 0.0;
    public float $mouseAvgAccel = 0.0;
    public int $mouseMovement = 0;
    public int $mouseClicks = 0;
    public int $mouseSelections = 0;
    public int $mouseScrolls = 0;

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
                    $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('authentication.verification_succeeded'), 'options' => ['timeOut' => 1000]]);
                    $this->loginScoreResponse['status'] = 'authentication.verification_succeeded';
                    $attempt = Auth::guard('api')->attempt(['email' => $validated['email'], 'password' => $validated['password']]);
                    if ($attempt) {
                        $this->loginScoreResponse['status'] = 'authentication.verification_succeeded';
                        $this->loginScoreResponse['bearer'] = $attempt;
                        $this->dispatchBrowserEvent('alert', ['type' => 'info', 'title' => 'Bearer', 'message' => $attempt, 'options' => ['timeOut' => 5000]]);
                        $this->confirmLoginAttempt($this->loginAttemptId);
                    } else {
                        $this->loginScoreResponse['status'] = 'authentication.wrong_email_password_combination';

                        $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('authentication.wrong_email_password_combination'), 'options' => ['timeOut' => 5000]]);
                    }
                } else {
                    $this->loginScoreResponse['status'] = 'authentication.code_not_match_or_expired';
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('authentication.code_not_match_or_expired'), 'options' => ['timeOut' => 5000]]);
                    return;
                }
            }
            $scoreEngineService = new ScoreEngineService();
            $mouseDynamics = [
                'timer' => $this->elapsedTime,
                'mouse_max_speed' => $this->mouseMaxSpeed,
                'mouse_avg_speed' => $this->mouseAvgSpeed,
                'mouse_max_accel' => $this->mouseMaxAccel,
                'mouse_avg_accel' => $this->mouseAvgAccel,
                'mouse_movement' => $this->mouseMovement,
                'mouse_clicks' => $this->mouseClicks,
                'mouse_selections' => $this->mouseSelections,
                'mouse_scrolls' => $this->mouseScrolls,
            ];
            $this->loginScoreResponse = $scoreEngineService->score(request(), array_merge($sanitized, $mouseDynamics));
            if (isset($this->loginScoreResponse['login_attempt_id'])) {
                $this->loginAttemptId = $this->loginScoreResponse['login_attempt_id'];
            }
            if (isset($this->loginScoreResponse['error']) && $this->loginScoreResponse['error'] === 'Entity is blacklisted') {
                $reason = match ($this->loginScoreResponse['blacklist_type']) {
                    'IP' => 'ip_address',
                    'DOMAIN' => 'domain',
                    'EMAIL' => 'email',
                    'OS' => 'operating_system',
                };
                $this->addError('scoring_engine', __('authentication.login_blocked_due_to_forbidden_'.$reason));
            } else {
                $settings = $scoreEngineService->fetchSettings();
                $twoFactorTresshold = $settings['scoring']['twofactor_when_score_gte'] ?? config('inove.login.enforce_twofactor_default_tresshold');
                $disallowTresshold = $settings['scoring']['disallow_when_score_gte'] ?? config('inove.login.disallow_default_tresshold');
                if (!$this->twoFactorRequired && isset($this->loginScoreResponse['score']) && $this->loginScoreResponse['score'] >= $twoFactorTresshold && $this->loginScoreResponse['score'] < $disallowTresshold) {
                    Enforce2FAEvent::dispatch($user);
                    $this->twoFactorRequired = true;
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('authentication.verification_code_required'), 'options' => ['timeOut' => 5000]]);
                    $this->addError('verification_code', __('authentication.insert_code_from_email'));
                } else {
                    $attempt = Auth::guard('api')->attempt(['email' => $validated['email'], 'password' => $validated['password']]);
                    if ($attempt) {
                        $this->loginScoreResponse['status'] = 'authentication.verification_succeeded';
                        $this->loginScoreResponse['bearer'] = $attempt;
                        $this->dispatchBrowserEvent('alert', ['type' => 'info', 'title' => 'Bearer', 'message' => $attempt, 'options' => ['timeOut' => 5000]]);
                        $this->confirmLoginAttempt($this->loginAttemptId);
                    } else {
                        $this->loginScoreResponse['status'] = 'authentication.wrong_email_password_combination';
                        $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('authentication.wrong_email_password_combination'), 'options' => ['timeOut' => 5000]]);
                    }
                }

                if (isset($this->loginScoreResponse['score']) && $this->loginScoreResponse['score'] >= $disallowTresshold) {
                    $this->loginScoreResponse['status'] = 'authentication.disallow_score_treshold_reached';
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('authentication.disallow_score_treshold_reached'), 'options' => ['timeOut' => 5000]]);
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

