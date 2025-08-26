<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EpisodeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'series_id'    => $this->series_id,
            'title'        => $this->title,
            'description'  => $this->description,
            'video_url'    => $this->video_url,
            'duration'     => $this->duration,
            'release_date' => $this->release_date,
            'created_at'   => $this->created_at,
        ];
    }
}
