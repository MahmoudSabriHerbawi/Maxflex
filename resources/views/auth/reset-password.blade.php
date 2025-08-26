@extends('layouts.master')
@section('title','Reset Password')

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-md-6 col-lg-5">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h1 class="h4 mb-3 text-center">Max Flex — Reset password</h1>

        @if ($errors->any())
          <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <form method="POST" action="{{ route('password.store') }}" novalidate>
          @csrf
          <input type="hidden" name="token" value="{{ request()->route('token') }}">

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', request('email')) }}" class="form-control" required autofocus>
          </div>
          <div class="mb-3">
            <label class="form-label">New password</label>
            <input type="password" name="password" class="form-control" required minlength="6">
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm new password</label>
            <input type="password" name="password_confirmation" class="form-control" required minlength="6">
          </div>

          <button class="btn btn-primary w-100">Reset password</button>
        </form>

        <div class="text-center mt-3">
          <a href="{{ route('login') }}">Back to login</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
