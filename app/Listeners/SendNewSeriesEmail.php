<?php

namespace App\Listeners;

use App\Events\SeriesCreated;
use App\Models\{Series, User};
use App\Notifications\NewSeriesNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewSeriesEmail implements ShouldQueue
{
    public $tries = 3;

    public function handle(SeriesCreated $event): void
    {
        $series = Series::with('categories')->find($event->seriesId);
        if (!$series) return;

        User::where('role','admin')->chunk(100, function($admins) use ($series){
            foreach ($admins as $admin) {
                $admin->notify(new NewSeriesNotification($series));
            }
        });
    }
}
