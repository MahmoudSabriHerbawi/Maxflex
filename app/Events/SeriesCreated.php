<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class SeriesCreated
{
    use Dispatchable;

    public int $seriesId;

    public function __construct(int $seriesId)
    {
        $this->seriesId = $seriesId;
    }
}
