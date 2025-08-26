@extends('layouts.master')
@section('title','Profile')

@section('content')
@php $u = auth()->user(); @endphp

<div class="mb-4">
  <h1 class="h4 mb-1">Profile</h1>
  <div class="text-muted">Manage your account settings and preferences.</div>
</div>

@if (session('status'))
  <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="row g-3">
  {{-- Update profile information --}}
  <div class="col-12 col-lg-6">
    <div class="card">
      <div class="card-body">
        <h2 class="h5 mb-3">Profile information</h2>

        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="needs-validation" novalidate>
          @csrf @method('PATCH')
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" type="text" value="{{ old('name',$u->name) }}" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input name="email" type="email" value="{{ old('email',$u->email) }}" class="form-control" required>
            @if (!$u->hasVerifiedEmail())
              <div class="small mt-2">
                <span class="text-warning">Email not verified.</span>
                <form class="d-inline" method="POST" action="{{ route('verification.send') }}">@csrf
                  <button class="btn btn-link btn-sm p-0 align-baseline">Resend verification</button>
                </form>
              </div>
            @endif
          </div>

          <div class="d-flex gap-2">
            <button class="btn btn-primary">Save changes</button>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Update password --}}
  <div class="col-12 col-lg-6">
    <div class="card">
      <div class="card-body">
        <h2 class="h5 mb-3">Update password</h2>

        @if (session('password_status'))
          <div class="alert alert-success">{{ session('password_status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="needs-validation" novalidate>
          @csrf @method('PUT')
          <div class="mb-3">
            <label class="form-label">Current password</label>
            <input name="current_password" type="password" class="form-control" required autocomplete="current-password">
          </div>
          <div class="mb-3">
            <label class="form-label">New password</label>
            <input name="password" type="password" class="form-control" required autocomplete="new-password" minlength="6">
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm new password</label>
            <input name="password_confirmation" type="password" class="form-control" required autocomplete="new-password" minlength="6">
          </div>

          <button class="btn btn-primary">Update password</button>
        </form>
      </div>
    </div>
  </div>

  {{-- Delete account --}}
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h2 class="h5 mb-2 text-danger">Delete account</h2>
        <p class="text-muted mb-3">Once your account is deleted, all of its resources and data will be permanently deleted.</p>

        <form method="POST" action="{{ route('profile.destroy') }}"
              onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
          @csrf @method('DELETE')
          <div class="row g-2 align-items-center">
            <div class="col-12 col-md-4">
              <input type="password" name="password" class="form-control" placeholder="Confirm with password" required>
            </div>
            <div class="col-12 col-md-auto">
              <button class="btn btn-outline-danger">Delete my account</button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection
