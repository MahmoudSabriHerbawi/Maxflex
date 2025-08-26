@extends('layouts.master')
@section('title','Create Episode')

@section('content')
<h1 class="h4 mb-3">Create Episode</h1>

@if ($errors->any())
  <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif

<form action="{{ route('admin.episodes.store') }}" method="POST" class="row g-3">
  @csrf
  <div class="col-md-6">
    <label class="form-label">Series</label>
    <select name="series_id" class="form-select" required>
      @foreach($series as $s)
        <option value="{{ $s->id }}">{{ $s->title }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-6">
    <label class="form-label">Title</label>
    <input name="title" value="{{ old('title') }}" class="form-control" required>
  </div>
  <div class="col-12">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
  </div>
  <div class="col-md-6">
    <label class="form-label">Video URL</label>
    <input name="video_url" value="{{ old('video_url') }}" class="form-control" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Duration (min)</label>
    <input type="number" min="0" name="duration" value="{{ old('duration') }}" class="form-control">
  </div>
  <div class="col-md-3">
    <label class="form-label">Release date</label>
    <input type="date" name="release_date" value="{{ old('release_date') }}" class="form-control">
  </div>
  <div class="col-12 d-flex gap-2">
    <button class="btn btn-primary">Save</button>
    <a href="{{ route('admin.episodes.index') }}" class="btn btn-outline-secondary">Cancel</a>
  </div>
</form>
@endsection
