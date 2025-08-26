<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Series;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $items = $request->user()
            ->favorites()
            ->with(['categories','episodes'])
            ->latest('favorites.id')
            ->get();

        return view('front.favorites', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'series_id' => ['required','exists:series,id'],
        ]);

        $request->user()->favorites()->syncWithoutDetaching([$data['series_id']]);

        return back()->with('ok', 'Added to favorites');
    }

    public function destroy(Request $request, Series $series)
    {
        $request->user()->favorites()->detach($series->id);

        return back()->with('ok', 'Removed from favorites');
    }
}
