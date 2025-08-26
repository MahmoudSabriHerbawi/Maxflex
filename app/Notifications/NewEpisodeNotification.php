<?php

namespace App\Notifications;

use App\Models\Episode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\{Notification, Messages\MailMessage};

class NewEpisodeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Episode $episode) {}

    public function via($notifiable): array
    {
        return ['mail','database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New episode: '.$this->episode->title)
            ->line('A new episode has been released for a series you follow.')
            ->action('Watch now', $this->episode->video_url)
            ->line('Enjoy watching on Max Flex!');
    }

    public function toArray($notifiable): array
    {
        return [
            'type'        => 'episode',
            'id'          => $this->episode->id,
            'title'       => $this->episode->title,
            'series_id'   => $this->episode->series_id,
            'video_url'   => $this->episode->video_url,
            'release_date'=> $this->episode->release_date,
        ];
    }
}
