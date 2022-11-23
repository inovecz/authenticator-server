<?php

namespace App\Listeners;

use App\Events\Enforce2FAEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\SendVerificationCodeNotification;

class GenerateVerificationCode implements ShouldQueue
{
    public string $queue = 'top';
    public int $delay = 15;

    public function __construct()
    {
        //
    }

    public function handle(Enforce2FAEvent $event): void
    {
        $verificationCode = $event->user->verificationCode()->create();
        $event->user->notify(new SendVerificationCodeNotification($verificationCode));
    }

    public function shouldQueue(Enforce2FAEvent $event): bool
    {
        return true;
    }
}
