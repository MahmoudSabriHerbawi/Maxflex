<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SeriesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'cover_image' => $this->cover_image,
            'status'      => $this->status,
            'categories'  => $this->whenLoaded('categories', fn () => $this->categories->pluck('name')),
            'episodes'    => EpisodeResource::collection($this->whenLoaded('episodes')),
            'created_at'  => $this->created_at,
        ];
    }
}
