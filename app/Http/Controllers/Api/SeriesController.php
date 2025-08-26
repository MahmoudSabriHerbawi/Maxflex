<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SeriesResource;
use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    // GET /api/series
    public function index(Request $r)
    {
        $list = Series::with(['categories','episodes'])
            ->when($r->q, fn($q)=>$q->where('title','like',"%{$r->q}%"))
            ->latest()->get();

        return SeriesResource::collection($list);
    }

    // GET /api/series/{id}
    public function show($id)
    {
        $series = Series::with(['categories','episodes'])->findOrFail($id);
        return new SeriesResource($series);
    }
}
