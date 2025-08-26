@extends('layouts.master')
@section('title','Login')

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-md-6 col-lg-5">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h1 class="h4 mb-3 text-center">Max Flex — Login</h1>

        @if (session('status'))
          <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
          <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <form method="POST" action="{{ route('login') }}" novalidate>
          @csrf
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="remember" id="remember">
              <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <a href="{{ route('password.request') }}">Forgot password?</a>
          </div>
          <button class="btn btn-primary w-100">Sign in</button>
        </form>

        <div class="text-center mt-3">
          <small>Don’t have an account?</small>
          <a href="{{ route('register') }}">Create one</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
