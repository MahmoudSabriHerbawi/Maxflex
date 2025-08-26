@extends('layouts.master')
@section('title','Edit Series')

@section('content')
<h1 class="h4 mb-3">Edit Series</h1>

@if ($errors->any())
  <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif

<form action="{{ route('admin.series.update',$series) }}" method="POST" enctype="multipart/form-data" class="row g-3">
  @csrf @method('PUT')
  <div class="col-md-6">
    <label class="form-label">Title</label>
    <input name="title" value="{{ old('title',$series->title) }}" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Status</label>
    <select name="status" class="form-select" required>
      <option value="active" @selected(old('status',$series->status)=='active')>Active</option>
      <option value="inactive" @selected(old('status',$series->status)=='inactive')>Inactive</option>
    </select>
  </div>
  <div class="col-12">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="4">{{ old('description',$series->description) }}</textarea>
  </div>
  <div class="col-md-6">
    <label class="form-label">Cover Image</label>
    <input type="file" name="cover_image" class="form-control">
    @if($series->cover_image)
      <div class="mt-2">
        <img src="{{ asset('storage/'.$series->cover_image) }}" alt="" class="img-thumbnail" style="max-height:120px">
      </div>
    @endif
  </div>
  <div class="col-md-6">
    <label class="form-label">Categories</label>
    <select name="category_ids[]" class="form-select" multiple>
      @foreach($categories as $c)
        <option value="{{ $c->id }}" @selected(in_array($c->id,$selected))>{{ $c->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-12 d-flex gap-2">
    <button class="btn btn-primary">Update</button>
    <a href="{{ route('admin.series.index') }}" class="btn btn-outline-secondary">Back</a>
  </div>
</form>
@endsection
