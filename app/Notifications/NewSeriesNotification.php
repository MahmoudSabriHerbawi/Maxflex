<?php

namespace App\Notifications;

use App\Models\Series;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\{Notification, Messages\MailMessage};

class NewSeriesNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Series $series) {}

    public function via($notifiable): array
    {
        return ['mail','database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New series added: '.$this->series->title)
            ->line('A new series has been created.')
            ->action('View series', route('front.series.show', $this->series))
            ->line('Thanks for using Max Flex!');
    }

    public function toArray($notifiable): array
    {
        return [
            'type'  => 'series',
            'id'    => $this->series->id,
            'title' => $this->series->title,
        ];
    }
}
