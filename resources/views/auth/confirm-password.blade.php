@extends('layouts.master')
@section('title','Confirm Password')

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-md-6 col-lg-5">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h1 class="h4 mb-3 text-center">Max Flex — Confirm password</h1>

        <p class="text-muted">
          This is a secure area of the application. Please confirm your password before continuing.
        </p>

        @if ($errors->any())
          <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <form method="POST" action="{{ route('password.confirm') }}" novalidate>
          @csrf
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required autofocus>
          </div>
          <button class="btn btn-primary w-100">Confirm</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
