<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class EpisodeCreated
{
    use Dispatchable;

    public int $episodeId;

    public function __construct(int $episodeId)
    {
        $this->episodeId = $episodeId;
    }
}
