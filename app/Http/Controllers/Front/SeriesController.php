<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Series;
use App\Models\Category;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index(Request $r)
    {
        $series = Series::with('categories')
            ->active()
            ->when($r->q, fn($q)=>$q->where('title','like',"%{$r->q}%"))
            ->when($r->category_id, fn($q)=>$q->whereHas('categories', fn($q)=>$q->where('categories.id',$r->category_id)))
            ->latest()->paginate(12)->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('front.series.index', compact('series','categories'));
    }

    public function show(Series $series)
    {
        $series->load(['categories','episodes'=>fn($q)=>$q->latest()]);
        return view('front.series.show', compact('series'));
    }
}
