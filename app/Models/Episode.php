<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;
    protected $fillable = ['series_id', 'title', 'description', 'video_url', 'duration', 'release_date'];
    public function series()
    {
        return $this->belongsTo(Series::class);
    }
}
