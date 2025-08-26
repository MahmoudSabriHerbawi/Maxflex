@extends('layouts.master')
@section('title','Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h4 mb-0">Welcome{{ isset($user) ? ', '.$user->name : '' }}</h1>
  <div>
    <a href="{{ route('front.series.index') }}" class="btn btn-outline-primary btn-sm">Browse Series</a>
    @auth
      <a href="{{ route('favorites.index') }}" class="btn btn-outline-secondary btn-sm">My Favorites</a>
      @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.series.index') }}" class="btn btn-primary btn-sm">Admin Panel</a>
      @endif
    @endauth
  </div>
</div>

<div class="row g-3">
  <div class="col-12 col-md-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="text-muted small">Total Series</div>
        <div class="h3 mb-0">{{ $seriesCount }}</div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="text-muted small">Total Episodes</div>
        <div class="h3 mb-0">{{ $episodesCount }}</div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="text-muted small">My Favorites</div>
        <div class="h3 mb-0">{{ $favoritesCount }}</div>
      </div>
    </div>
  </div>
</div>

<div class="mt-4">
  <div class="card">
    <div class="card-body">
      <h2 class="h5 mb-3">Quick Actions</h2>
      <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('front.series.index') }}" class="btn btn-outline-primary">Discover series</a>
        <a href="{{ route('favorites.index') }}" class="btn btn-outline-secondary">View favorites</a>
        @if(auth()->user()->role === 'admin')
          <a href="{{ route('admin.series.index') }}" class="btn btn-primary">Manage series</a>
          <a href="{{ route('admin.episodes.index') }}" class="btn btn-primary">Manage episodes</a>
          <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Manage categories</a>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
