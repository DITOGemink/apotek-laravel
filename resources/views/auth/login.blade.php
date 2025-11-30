@extends('layouts.master')

@section('title','Login - Apotek')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
  <div class="card shadow-sm w-100" style="max-width: 420px;">
    <div class="card-body p-4">
      <div class="text-center mb-3">
        <div class="mb-2">
          <i class="bi bi-capsule fs-1 text-primary"></i>
        </div>
        <h5 class="mb-0 fw-semibold">Login Apotek</h5>
        <small class="text-muted">Silakan masuk untuk melanjutkan</small>
      </div>

      {{-- Alert error umum --}}
      @if ($errors->any())
        <div class="alert alert-danger py-2">
          <small>Ada kesalahan pada input. Silakan cek kembali.</small>
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-3">
          <label for="email" class="form-label mb-1">Email Address</label>
          <input id="email"
                 type="email"
                 class="form-control @error('email') is-invalid @enderror"
                 name="email"
                 value="{{ old('email') }}"
                 required
                 autofocus>
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

        {{-- Remember me + Forgot --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
              Remember me
            </label>
          </div>

          @if (Route::has('password.request'))
            <a class="small text-decoration-none" href="{{ route('password.request') }}">
              Lupa password?
            </a>
          @endif
        </div>

        {{-- Tombol --}}
        <div class="d-grid mb-2">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-box-arrow-in-right me-1"></i> Login
          </button>
        </div>

        <div class="text-center">
          <small class="text-muted">
            Belum punya akun?
            @if (Route::has('register'))
              <a href="{{ route('register') }}">Daftar di sini</a>
            @endif
          </small>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
