@extends('layouts.master')
@section('title','Admin · Series')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4 mb-0">Series</h1>
  <a href="{{ route('admin.series.create') }}" class="btn btn-primary">Create Series</a>
</div>

<form class="row g-2 mb-3">
  <div class="col-md-4">
    <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Search by title...">
  </div>
  <div class="col-md-3">
    <select name="status" class="form-select">
      <option value="">All status</option>
      <option value="active" @selected(request('status')=='active')>Active</option>
      <option value="inactive" @selected(request('status')=='inactive')>Inactive</option>
    </select>
  </div>
  <div class="col-md-3">
    <select name="category_id" class="form-select">
      <option value="">All categories</option>
      @foreach($categories as $c)
        <option value="{{ $c->id }}" @selected(request('category_id')==$c->id)>{{ $c->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-2 d-grid">
    <button class="btn btn-secondary">Filter</button>
  </div>
</form>

@if($series->isEmpty())
  <div class="alert alert-info">No items found.</div>
@endif

<div class="table-responsive">
  <table class="table align-middle">
    <thead>
      <tr>
        <th>#</th>
        <th>Title</th>
        <th>Categories</th>
        <th>Status</th>
        <th>Created</th>
        <th class="text-end">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($series as $s)
      <tr>
        <td>{{ $s->id }}</td>
        <td>{{ $s->title }}</td>
        <td class="small">
          @foreach($s->categories as $cat)
            <span class="badge bg-light text-dark border">{{ $cat->name }}</span>
          @endforeach
        </td>
        <td>
          <span class="badge {{ $s->status=='active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($s->status) }}</span>
        </td>
        <td>{{ $s->created_at->format('Y-m-d') }}</td>
        <td class="text-end">
          <a href="{{ route('admin.series.edit',$s) }}" class="btn btn-sm btn-warning">Edit</a>
          <form action="{{ route('admin.series.destroy',$s) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this series?')">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

{{ $series->links() }}
@endsection
