<?php

namespace App\Notifications;

use App\Models\Partner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PartnerQuotaReached extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Partner $partner, public readonly int $limit) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(config('app.name').' - application limit reached')
            ->greeting('Hello '.$this->partner->name)
            ->line("Your organisation has reached its limit of {$this->limit} applications for this year.")
            ->line('Please contact the UNICEF information management focal point if more codes are needed.');
    }
}
