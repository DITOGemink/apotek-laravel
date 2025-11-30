@extends('layouts.master')

@section('title','Ganti Password - Apotek')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
  <div class="card shadow-sm w-100" style="max-width: 450px;">
    <div class="card-body p-4">
      <h5 class="mb-3 fw-semibold">
        <i class="bi bi-key me-1"></i> Ganti Password
      </h5>

      {{-- Notif error --}}
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0 small">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- Notif sukses (kalau pakai session('message')) --}}
      @if (Session::has('message'))
        <div class="alert alert-success py-2 mb-3">
          <small>{{ Session::get('message') }}</small>
        </div>
      @endif

      <form action="{{ route('store_password') }}" method="post">
        @method('patch')
        @csrf

        <div class="mb-3">
          <label for="new_password" class="form-label mb-1">Password Baru</label>
          <input type="password"
                 name="new_password"
                 id="new_password"
                 class="form-control @error('new_password') is-invalid @enderror"
                 required>
          @error('new_password')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="new_password_confirmation" class="form-label mb-1">Konfirmasi Password Baru</label>
          <input type="password"
                 name="new_password_confirmation"
                 id="new_password_confirmation"
                 class="form-control"
                 required>
        </div>

        <div class="d-flex justify-content-between">
          <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
            Kembali
          </a>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle me-1"></i> Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
