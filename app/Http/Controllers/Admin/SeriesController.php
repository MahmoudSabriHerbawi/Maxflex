<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Series;
use App\Models\Category;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Series::class, 'series');
    }

    public function index(Request $r)
    {
        $series = Series::with('categories')
            ->when($r->q, fn($q)=>$q->where('title','like',"%{$r->q}%"))
            ->when($r->status, fn($q)=>$q->where('status',$r->status))
            ->when($r->category_id, fn($q)=>$q->whereHas('categories',fn($q)=>$q->where('categories.id',$r->category_id)))
            ->latest()->paginate(12)->withQueryString();

        $categories = Category::orderBy('name')->get();
        return view('admin.series.index', compact('series','categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.series.create', compact('categories'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'cover_image' => 'nullable|image|max:2048',
            'category_ids' => 'array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        if($r->hasFile('cover_image')){
            $data['cover_image'] = $r->file('cover_image')->store('covers','public');
        }

        $series = Series::create($data);
        $series->categories()->sync($r->input('category_ids',[]));

        return redirect()->route('admin.series.index')->with('ok','Created');
    }

    public function edit(Series $series)
    {
        $categories = Category::orderBy('name')->get();
        $selected = $series->categories()->pluck('id')->all();
        return view('admin.series.edit', compact('series','categories','selected'));
    }

    public function update(Request $r, Series $series)
    {
        $data = $r->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'cover_image' => 'nullable|image|max:2048',
            'category_ids' => 'array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        if($r->hasFile('cover_image')){
            $data['cover_image'] = $r->file('cover_image')->store('covers','public');
        }

        $series->update($data);
        $series->categories()->sync($r->input('category_ids',[]));

        return redirect()->route('admin.series.index')->with('ok','Updated');
    }

    public function destroy(Series $series)
    {
        $series->delete();
        return back()->with('ok','Deleted');
    }
}
