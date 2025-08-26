<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\Episode;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $seriesCount   = Series::count();
        $episodesCount = Episode::count();
        $favoritesCount = $user ? $user->favorites()->count() : 0;

        return view('dashboard', compact('seriesCount','episodesCount','favoritesCount','user'));
    }
}
