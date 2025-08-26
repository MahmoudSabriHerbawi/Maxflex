@extends('layouts.master')
@section('title','Admin · Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4 mb-0">Categories</h1>
  <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Create Category</a>
</div>

<form class="row g-2 mb-3">
  <div class="col-md-6">
    <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Search by name...">
  </div>
  <div class="col-md-2 d-grid">
    <button class="btn btn-secondary">Filter</button>
  </div>
</form>

@if($categories->isEmpty())
  <div class="alert alert-info">No items found.</div>
@endif

<div class="table-responsive">
  <table class="table align-middle">
    <thead><tr><th>#</th><th>Name</th><th>Created</th><th class="text-end">Actions</th></tr></thead>
    <tbody>
      @foreach($categories as $c)
      <tr>
        <td>{{ $c->id }}</td>
        <td>{{ $c->name }}</td>
        <td>{{ $c->created_at->format('Y-m-d') }}</td>
        <td class="text-end">
          <a href="{{ route('admin.categories.edit',$c) }}" class="btn btn-sm btn-warning">Edit</a>
          <form action="{{ route('admin.categories.destroy',$c) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

{{ $categories->links() }}
@endsection
