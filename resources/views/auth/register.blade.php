@extends('layouts.master')
@section('title','Register')

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-md-6 col-lg-5">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h1 class="h4 mb-3 text-center">Max Flex — Create account</h1>

        @if ($errors->any())
          <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <form method="POST" action="{{ route('register') }}" novalidate>
          @csrf
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required minlength="6">
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required minlength="6">
          </div>
          {{-- role defaults to "user" in DB --}}
          <button class="btn btn-primary w-100">Create account</button>
        </form>

        <div class="text-center mt-3">
          <small>Already have an account?</small>
          <a href="{{ route('login') }}">Login</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
