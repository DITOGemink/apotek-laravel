@extends('layouts.master')

@section('title', 'Sistem Informasi Apotek')

@section('content')
<div class="container py-5">
  <div class="text-center">
    <h1 class="mb-3 fw-bold">Sistem Informasi Apotek</h1>
    <p class="lead mb-4">
      Kelola data obat, supplier, dan transaksi penjualan dengan mudah dan terintegrasi.
    </p>

    @guest
      <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">Login</a>
      <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg">Register</a>
    @else
      <a href="{{ route('home') }}" class="btn btn-success btn-lg">Masuk ke Dashboard</a>
    @endguest
  </div>
</div>
@endsection
