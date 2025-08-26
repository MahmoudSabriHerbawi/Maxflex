@extends('layouts.master')
@section('title','Forgot Password')

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-md-6 col-lg-5">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h1 class="h4 mb-3 text-center">Max Flex — Forgot password</h1>

        @if (session('status'))
          <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
          <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <p class="small text-muted mb-3">
          Enter your email and we will send you a password reset link.
        </p>

        <form method="POST" action="{{ route('password.email') }}" novalidate>
          @csrf
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
          </div>
          <button class="btn btn-primary w-100">Send reset link</button>
        </form>

        <div class="text-center mt-3">
          <a href="{{ route('login') }}">Back to login</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
