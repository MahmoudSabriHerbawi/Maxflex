<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\Episode;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $seriesCount    = Series::count();
        $episodesCount  = Episode::count();
        $favoritesCount = $user ? $user->favorites()->count() : 0;

        // For regular users: show favorite series list on the dashboard
        $favoriteSeries = collect();
        if ($user && $user->role === 'user') {
            $favoriteSeries = $user->favorites()
                ->with('categories')
                ->latest('favorites.id')
                ->take(12)
                ->get();
        }

        return view('dashboard', compact(
            'seriesCount',
            'episodesCount',
            'favoritesCount',
            'favoriteSeries',
            'user'
        ));
    }
}
