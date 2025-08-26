<?php

namespace App\Http\Controllers\Admin;

use App\Models\Series;
use App\Models\Episode;
use Illuminate\Http\Request;
use App\Events\EpisodeCreated;
use App\Http\Controllers\Controller;

class EpisodeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Episode::class, 'episode');
    }

    public function index(Request $r)
    {
        $episodes = Episode::with('series')
            ->when($r->series_id, fn($q)=>$q->where('series_id',$r->series_id))
            ->when($r->q, fn($q)=>$q->where('title','like',"%{$r->q}%"))
            ->latest()->paginate(20)->withQueryString();

        $series = Series::orderBy('title')->get();
        return view('admin.episodes.index', compact('episodes','series'));
    }

    public function create()
    {
        $series = Series::orderBy('title')->get();
        return view('admin.episodes.create', compact('series'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'series_id'    => 'required|exists:series,id',
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'video_url'    => 'required|string|max:1000',
            'duration'     => 'nullable|integer|min:0',
            'release_date' => 'nullable|date',
        ]);

        $episode = Episode::create($data);
        event(new EpisodeCreated($episode->id));

        return redirect()->route('admin.episodes.index')->with('ok','Created');
}


    public function edit(Episode $episode)
    {
        $series = Series::orderBy('title')->get();
        return view('admin.episodes.edit', compact('episode','series'));
    }

    public function update(Request $r, Episode $episode)
    {
        $data = $r->validate([
            'series_id' => 'required|exists:series,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|string|max:1000',
            'duration' => 'nullable|integer|min:0',
            'release_date' => 'nullable|date',
        ]);

        $episode->update($data);
        return redirect()->route('admin.episodes.index')->with('ok','Updated');
    }

    public function destroy(Episode $episode)
    {
        $episode->delete();
        return back()->with('ok','Deleted');
    }
}
