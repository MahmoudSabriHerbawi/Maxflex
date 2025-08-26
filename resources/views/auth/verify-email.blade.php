@extends('layouts.master')
@section('title','Verify Email')

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-md-8 col-lg-6">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h1 class="h4 mb-3 text-center">Max Flex — Verify your email</h1>

        @if (session('status') == 'verification-link-sent')
          <div class="alert alert-success">
            A new verification link has been sent to your email address.
          </div>
        @endif

        <p class="text-muted">
          Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you.
          If you didn’t receive the email, we will gladly send you another.
        </p>

        <div class="d-flex gap-2">
          <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button class="btn btn-primary">Resend verification email</button>
          </form>

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-danger">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
