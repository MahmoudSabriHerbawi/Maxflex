@extends('layouts.master')
@section('title','Admin · Episodes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4 mb-0">Episodes</h1>
  <a href="{{ route('admin.episodes.create') }}" class="btn btn-primary">Create Episode</a>
</div>

<form class="row g-2 mb-3">
  <div class="col-md-6">
    <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Search by title...">
  </div>
  <div class="col-md-4">
    <select name="series_id" class="form-select">
      <option value="">All series</option>
      @foreach($series as $s)
        <option value="{{ $s->id }}" @selected(request('series_id')==$s->id)>{{ $s->title }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-2 d-grid">
    <button class="btn btn-secondary">Filter</button>
  </div>
</form>

@if($episodes->isEmpty())
  <div class="alert alert-info">No items found.</div>
@endif

<div class="table-responsive">
  <table class="table align-middle">
    <thead><tr>
      <th>#</th><th>Title</th><th>Series</th><th>Duration</th><th>Release</th><th class="text-end">Actions</th>
    </tr></thead>
    <tbody>
      @foreach($episodes as $e)
      <tr>
        <td>{{ $e->id }}</td>
        <td>{{ $e->title }}</td>
        <td>{{ $e->series?->title }}</td>
        <td>{{ $e->duration ? $e->duration.' min' : 'N/A' }}</td>
        <td>{{ $e->release_date ?? 'N/A' }}</td>
        <td class="text-end">
          <a href="{{ route('admin.episodes.edit',$e) }}" class="btn btn-sm btn-warning">Edit</a>
          <form action="{{ route('admin.episodes.destroy',$e) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this episode?')">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

{{ $episodes->links() }}
@endsection
