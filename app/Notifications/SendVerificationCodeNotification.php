<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\VerificationCode;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SendVerificationCodeNotification extends Notification
{
    use Queueable;

    public function __construct(protected VerificationCode $verificationCode)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Ověření přihlášení')
            ->greeting('Dobrý den')
            ->line('Jednorázový kód pro přístup do ... je')
            ->line(new HtmlString('<span style="margin-top: 2rem; margin-bottom: 2rem; font-size: 3rem; color: #333333;">'.$this->verificationCode->getCode().'</span>'))
            ->line('Kód je platný do '.$this->verificationCode->getValidUntil()->format('d.m.Y H:i'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
