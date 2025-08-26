<?php

namespace App\Listeners;

use App\Events\EpisodeCreated;
use App\Models\Episode;
use App\Notifications\NewEpisodeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyFollowersNewEpisode implements ShouldQueue
{
    public $tries = 3;

    public function handle(\App\Events\EpisodeCreated $event): void
    {
        $episode = Episode::with(['series.fans' => function($q) {
            $q->where('role', 'user'); // for users only
        }])->find($event->episodeId);

        if (!$episode) return;

        foreach ($episode->series->fans as $user) {
            $user->notify(new NewEpisodeNotification($episode));
        }
    }
}
