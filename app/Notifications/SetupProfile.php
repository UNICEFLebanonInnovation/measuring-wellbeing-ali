<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/** Sent to a newly created partner or collector so they can set their password. */
class SetupProfile extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly string $token, public readonly string $role) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = route('profile.setup', ['token' => $this->token, 'email' => $notifiable->email]);

        return (new MailMessage)
            ->subject(config('app.name').' - set up your '.$this->role.' account')
            ->greeting('Hello '.$notifiable->name)
            ->line('An account has been created for you on the Measuring Well-Being platform.')
            ->action('Set your password', $url)
            ->line('This link expires in '.config('auth.passwords.users.expire', 60).' minutes. If it has expired, use "Forgot password" on the login page with this email address.');
    }
}
