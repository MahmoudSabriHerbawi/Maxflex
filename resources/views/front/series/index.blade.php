@extends('layouts.master')
@section('title','Series')

@section('content')
<form class="row g-2 mb-3">
  <div class="col-md-6">
    <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Search series...">
  </div>
  <div class="col-md-4">
    <select name="category_id" class="form-select">
      <option value="">All categories</option>
      @foreach($categories as $c)
        <option value="{{ $c->id }}" @selected(request('category_id')==$c->id)>{{ $c->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-2 d-grid">
    <button class="btn btn-primary">Filter</button>
  </div>
</form>

@if($series->isEmpty())
  <div class="alert alert-info">No results found.</div>
@endif

<div class="row g-3">
@foreach($series as $s)
  <div class="col-12 col-sm-6 col-lg-4">
    <div class="card h-100">
    @php
        $cover = $s->cover_image ? asset('storage/'.$s->cover_image) : asset('images/default-cover.jpg');
    @endphp
    <img src="{{ $cover }}" class="card-img-top" alt="{{ $s->title }}">
      <div class="card-body d-flex flex-column">
        <h5 class="card-title mb-1">{{ $s->title }}</h5>
        <div class="small text-muted mb-2">
          @foreach($s->categories as $cat)
            <span class="badge bg-secondary">{{ $cat->name }}</span>
          @endforeach
        </div>
        <p class="card-text text-truncate">{{ $s->description }}</p>
        <a href="{{ route('front.series.show',$s) }}" class="mt-auto btn btn-outline-primary btn-sm">Details</a>
      </div>
    </div>
  </div>
@endforeach
</div>

<div class="mt-3">
  {{ $series->links() }}
</div>
@endsection
