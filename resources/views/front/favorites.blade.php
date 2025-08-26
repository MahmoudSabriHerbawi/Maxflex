@extends('layouts.master')
@section('title','My Favorites')

@section('content')
@if($items->isEmpty())
  <div class="alert alert-info">Your favorites list is empty.</div>
@endif

<div class="row g-3">
@foreach($items as $s)
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
        <a href="{{ route('front.series.show',$s) }}" class="btn btn-outline-dark btn-sm">Details</a>
        <form method="POST" action="{{ route('favorites.destroy',$s->id) }}" class="mt-2">
          @csrf @method('DELETE')
          <button class="btn btn-danger btn-sm w-100">Remove</button>
        </form>
      </div>
    </div>
  </div>
@endforeach
</div>
@endsection
