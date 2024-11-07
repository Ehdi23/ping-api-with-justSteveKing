<?php

namespace App\Notifications;

use App\Models\Check;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CheckFailed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Check $check
    ){}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject("[Failed] Your check for {$this->check->name} seems to have failed")
                    ->line('We just checked your service, and it didn\'t response as we expected.')
                    ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'check' => $this->check->id,
            'message' => "Your check for {$this->check->name} seems to have failed",
        ];
    }
}
