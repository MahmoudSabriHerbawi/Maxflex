<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status'];

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'series_category');
    }
    public function fans()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function scopeActive($q)
    {
        return $q->where('status', 'active');
    }
    public function scopeSearch($q, $s)
    {
        return $q->when($s, fn($q) => $q->where('title', 'like', "%$s%"));
    }
}
