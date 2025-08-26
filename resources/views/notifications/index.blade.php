@extends('layouts.master')
@section('title','Notifications')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4 mb-0">Notifications</h1>
  <form method="POST" action="{{ route('notifications.readAll') }}">@csrf
    <button class="btn btn-outline-secondary btn-sm">Mark all as read</button>
  </form>
</div>

@if($notifications->isEmpty())
  <div class="alert alert-info">No notifications yet.</div>
@endif

<div class="list-group">
@foreach($notifications as $n)
  @php
    $data = $n->data;
    $type = $data['type'] ?? 'info';
  @endphp

  <div class="list-group-item d-flex justify-content-between align-items-start">
    <div class="me-3">
      <div class="fw-semibold">
        @if($type === 'series')
          New series: {{ $data['title'] ?? 'Untitled' }}
        @elseif($type === 'episode')
          New episode: {{ $data['title'] ?? 'Untitled' }}
        @else
          Notification
        @endif
        @if(is_null($n->read_at)) <span class="badge bg-primary ms-2">new</span> @endif
      </div>

      <div class="mt-1">
        @if($type === 'series' && isset($data['id']))
          <a class="btn btn-sm btn-outline-primary" href="{{ route('front.series.show', $data['id']) }}">View series</a>
        @elseif($type === 'episode' && isset($data['video_url']))
          <a class="btn btn-sm btn-outline-primary" target="_blank" href="{{ $data['video_url'] }}">Watch</a>
          @if(isset($data['series_id']))
            <a class="btn btn-sm btn-outline-secondary" href="{{ route('front.series.show', $data['series_id']) }}">Series page</a>
          @endif
        @endif
      </div>
    </div>

    {{-- time moved here, ID removed --}}
    <div class="text-end small text-muted">
      {{ $n->created_at->diffForHumans() }}
    </div>
  </div>
@endforeach
</div>

<div class="mt-3">
  {{ $notifications->links() }}
</div>
@endsection
