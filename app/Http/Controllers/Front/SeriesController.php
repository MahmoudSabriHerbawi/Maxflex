<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index(Request $r)
    {
        $series = \App\Models\Series::with('categories')
            ->active()
            ->when($r->q, fn($q)=>$q->where('title','like',"%{$r->q}%"))
            ->when($r->category_id, fn($q)=>$q->whereHas('categories', fn($q)=>$q->where('categories.id',$r->category_id)))
            ->latest()->paginate(12)->withQueryString();

        $categories = \App\Models\Category::orderBy('name')->get();

        return view('front.series.index', compact('series','categories'));
    }
}
