@extends('layouts.master')
@section('title', 'Dashboard')

@section('content')
    @php
        $role = auth()->user()->role ?? 'user';
        $unread = isset($unreadCount) ? $unreadCount : auth()->user()->unreadNotifications()->count();
    @endphp

    {{-- Welcome (without top action buttons) --}}
    <div class="mb-4">
        <h1 class="h4 mb-1">Welcome, {{ $user->name ?? auth()->user()->name }}</h1>
        <div class="text-muted">Have a productive session on Max Flex.</div>
    </div>

    {{-- Admin & Employee: stats cards --}}
    @if (in_array($role, ['admin', 'employee']))
        <div class="row g-3 mb-4">
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
    @else
        {{-- Regular user: show favorites grid instead of stats --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 mb-0">My Favorites</h2>
            <a href="{{ route('favorites.index') }}" class="btn btn-sm btn-outline-secondary">View all</a>
        </div>

        @if ($favoriteSeries->isEmpty())
            <div class="alert alert-info">Your favorites list is empty.</div>
        @else
            <div class="row g-3 mb-4">
                @foreach ($favoriteSeries as $s)
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card h-100">
                            @php
                                $cover = $s->cover_image
                                    ? asset('storage/' . $s->cover_image)
                                    : asset('images/default-cover.jpg');
                            @endphp
                            <img src="{{ $cover }}" class="card-img-top" alt="{{ $s->title }}">

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-1">{{ $s->title }}</h5>
                                <div class="small text-muted mb-2">
                                    @foreach ($s->categories as $cat)
                                        <span class="badge bg-secondary">{{ $cat->name }}</span>
                                    @endforeach
                                </div>
                                <a href="{{ route('front.series.show', $s) }}"
                                    class="btn btn-outline-primary btn-sm mt-auto">Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif

    {{-- Quick Actions (single place for actions) --}}
    <div class="card">
        <div class="card-body">
            <h2 class="h5 mb-3">Quick Actions</h2>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('front.series.index') }}" class="btn btn-outline-primary">Discover series</a>
                <a href="{{ route('favorites.index') }}" class="btn btn-outline-secondary">View favorites</a>

                @if ($role === 'admin')
                    <a href="{{ route('admin.series.index') }}" class="btn btn-primary">Manage series</a>
                    <a href="{{ route('admin.episodes.index') }}" class="btn btn-primary">Manage episodes</a>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Manage categories</a>
                @elseif($role === 'employee')
                    <a href="{{ route('admin.episodes.index') }}" class="btn btn-primary">Manage episodes</a>
                @endif

                <a href="{{ route('notifications.index') }}" class="btn btn-outline-dark">
                    Notifications @if ($unread)
                        <span class="badge bg-danger">{{ $unread }}</span>
                    @endif
                </a>
            </div>
        </div>
    </div>
@endsection
