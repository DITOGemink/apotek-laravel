@extends('layouts.master')

@section('title','Register - Apotek')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
  <div class="card shadow-sm w-100" style="max-width: 460px;">
    <div class="card-body p-4">
      <div class="text-center mb-3">
        <div class="mb-2">
          <i class="bi bi-capsule fs-1 text-primary"></i>
        </div>
        <h5 class="mb-0 fw-semibold">Daftar Akun</h5>
        <small class="text-muted">Buat akun untuk mengakses sistem Apotek</small>
      </div>

      @if ($errors->any())
        <div class="alert alert-danger py-2">
          <small>Ada kesalahan pada input. Silakan cek kembali.</small>
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Name --}}
        <div class="mb-3">
          <label for="name" class="form-label mb-1">Nama</label>
          <input id="name"
                 type="text"
                 class="form-control @error('name') is-invalid @enderror"
                 name="name"
                 value="{{ old('name') }}"
                 required
                 autofocus>
          @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
          <label for="email" class="form-label mb-1">Email Address</label>
          <input id="email"
                 type="email"
                 class="form-control @error('email') is-invalid @enderror"
                 name="email"
                 value="{{ old('email') }}"
                 required>
          @error('email')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
          <label for="password" class="form-label mb-1">Password</label>
          <input id="password"
                 type="password"
                 class="form-control @error('password') is-invalid @enderror"
                 name="password"
                 required>
          @error('password')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div class="mb-3">
          <label for="password-confirm" class="form-label mb-1">Konfirmasi Password</label>
          <input id="password-confirm"
                 type="password"
                 class="form-control"
                 name="password_confirmation"
                 required>
        </div>

        <div class="d-grid mb-2">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i> Register
          </button>
        </div>

        <div class="text-center">
          <small class="text-muted">
            Sudah punya akun?
            <a href="{{ route('login') }}">Login</a>
          </small>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
