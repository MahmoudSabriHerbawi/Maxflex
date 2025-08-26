@extends('layouts.master')
@section('title', $series->title)

@section('content')
<div class="row g-4">
  <div class="col-md-4">
    @if($series->cover_image)
      <img src="{{ asset('storage/'.$series->cover_image) }}" class="img-fluid rounded-3" alt="{{ $series->title }}">
    @endif

    @auth
      <form method="POST" action="{{ route('favorites.store') }}" class="d-grid mt-3">
        @csrf
        <input type="hidden" name="series_id" value="{{ $series->id }}">
        <button class="btn btn-success">Add to Favorites</button>
      </form>
    @else
      <a href="{{ route('login') }}" class="btn btn-outline-success mt-3 w-100">Login to add favorites</a>
    @endauth
  </div>

  <div class="col-md-8">
    <h1 class="h4">{{ $series->title }}</h1>
    <p class="mb-2">{{ $series->description }}</p>
    <div class="mb-3">
      @foreach($series->categories as $cat)
        <span class="badge bg-secondary">{{ $cat->name }}</span>
      @endforeach
    </div>

    <h5 class="mt-4">Episodes</h5>
    <div class="list-group">
      @forelse($series->episodes as $e)
        <div class="list-group-item">
          <div class="d-flex justify-content-between">
            <div>
              <strong>{{ $e->title }}</strong>
              <div class="small text-muted">
                Duration: {{ $e->duration ? $e->duration.' min' : 'N/A' }}
                @if($e->release_date) • Release: {{ $e->release_date }} @endif
              </div>
            </div>
            <a href="{{ $e->video_url }}" target="_blank" class="btn btn-sm btn-primary">Watch</a>
          </div>
          @if($e->description)
            <div class="small mt-2 text-muted">{{ $e->description }}</div>
          @endif
        </div>
      @empty
        <div class="list-group-item">No episodes yet.</div>
      @endforelse
    </div>
  </div>
</div>
@endsection
