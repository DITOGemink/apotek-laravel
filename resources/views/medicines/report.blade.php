@extends('layouts.master')

@section('title','Laporan Data Obat')

@section('head')
<style>
  @media print {
    nav.navbar,
    .btn-print-hide {
      display: none !important;
    }
    body {
      background:#fff;
    }
    .report-container {
      max-width: 900px;
      margin: 0 auto;
    }
    .card {
      box-shadow: none !important;
      border: 1px solid #000 !important;
    }
    .table th,
    .table td {
      border-color: #000 !important;
      font-size: 11px;
      padding: .35rem .5rem;
    }
  }
</style>
@endsection

@section('content')
<div class="container my-4 report-container">
  <div class="d-flex justify-content-between align-items-center mb-3 btn-print-hide">
    <div>
      <h1 class="h4 mb-0">
        <i class="bi bi-file-earmark-text me-1"></i> Laporan Data Obat
      </h1>
      <small class="text-muted">
        Dicetak pada: {{ now()->format('d-m-Y H:i') }}
      </small>
    </div>
    <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
      <i class="bi bi-printer me-1"></i> Cetak
    </button>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">

      {{-- HEADER KHUSUS SAAT PRINT --}}
      <div class="mb-3 text-center d-none d-print-block">
        <h5 class="mb-0">Apotek {{ config('app.name', 'Laravel') }}</h5>
        <small>Laporan Data Obat</small>
        <hr class="mt-2 mb-3">
      </div>

      <div class="table-responsive">
        <table class="table table-sm align-middle">
          <thead class="table-light">
            <tr>
              <th style="width:40px;">#</th>
              <th>Nama Obat</th>
              <th>Kategori</th>
              <th class="text-end" style="width:110px;">Harga</th>
              <th class="text-center" style="width:80px;">Stok</th>
              <th style="width:110px;">Kadaluarsa</th>
            </tr>
          </thead>
          <tbody>
            @forelse($medicines as $m)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $m->name }}</td>
                <td>{{ $m->category->name ?? '-' }}</td>
                <td class="text-end">Rp {{ number_format($m->price,0,',','.') }}</td>
                <td class="text-center">{{ $m->stock }}</td>
                <td>{{ $m->exp_date ? \Carbon\Carbon::parse($m->exp_date)->format('d-m-Y') : '-' }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center text-muted">Belum ada data obat.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- FOOTER TANDA TANGAN / INFO CETAK --}}
      <div class="row mt-4">
        <div class="col-6">
          <small class="text-muted">
            Dicetak oleh: {{ auth()->user()->name ?? '-' }}
          </small>
        </div>
        <div class="col-6 text-end">
          <small class="text-muted">
            Tanggal: {{ now()->format('d-m-Y') }}
          </small>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
