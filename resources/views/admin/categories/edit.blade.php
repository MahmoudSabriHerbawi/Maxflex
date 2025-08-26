@extends('layouts.master')
@section('title','Edit Category')

@section('content')
<h1 class="h4 mb-3">Edit Category</h1>

@if ($errors->any())
  <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif

<form action="{{ route('admin.categories.update',$category) }}" method="POST" class="row g-3">
  @csrf @method('PUT')
  <div class="col-md-6">
    <label class="form-label">Name</label>
    <input name="name" value="{{ old('name',$category->name) }}" class="form-control" required>
  </div>
  <div class="col-12 d-flex gap-2">
    <button class="btn btn-primary">Update</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Back</a>
  </div>
</form>
@endsection
