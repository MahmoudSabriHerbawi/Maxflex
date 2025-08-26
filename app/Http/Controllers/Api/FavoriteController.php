<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SeriesResource;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // GET /api/favorites  (requires sanctum)
    public function index(Request $r)
    {
        $items = $r->user()->favorites()->with(['categories','episodes'])->get();
        return SeriesResource::collection($items);
    }

    // POST /api/favorites  (requires sanctum)
    public function store(Request $r)
    {
        $data = $r->validate(['series_id'=>'required|exists:series,id']);
        $r->user()->favorites()->syncWithoutDetaching([$data['series_id']]);
        return response()->json(['message'=>'added'], 201);
    }
}
