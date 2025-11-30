@extends('layouts.master')

@section('title', 'Detail Transaksi')

@section('head')
<style>
  /* Saat print: hilangkan navbar & tombol, pakai layout lebih sempit */
  @media print {
    nav.navbar,
    .btn-print-hide {
      display: none !important;
    }
    body {
      background: #fff;
    }
    .print-container {
      max-width: 700px;
      margin: 0 auto;
    }
    .card {
      box-shadow: none !important;
      border: 1px solid #000 !important;
    }
    .table th,
    .table td {
      border-color: #000 !important;
    }
  }
</style>
@endsection

@section('content')
<div class="container my-4 print-container">
  {{-- BARIS ATAS: judul + tombol --}}
  <div class="d-flex justify-content-between align-items-center mb-3 btn-print-hide">
    <h1 class="h4 mb-0">
      <i class="bi bi-receipt-cutoff me-1"></i> Detail Transaksi #{{ $sale->id }}
    </h1>
    <div class="d-flex gap-2">
      <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
        <i class="bi bi-printer me-1"></i> Cetak
      </button>
      <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
      </a>
    </div>
  </div>

  {{-- HEADER KHUSUS SAAT PRINT --}}
  <div class="text-center mb-3 d-none d-print-block">
    <h5 class="mb-0">Apotek {{ config('app.name', 'Laravel') }}</h5>
    <small>Struk Penjualan</small>
    <hr class="mt-2 mb-3">
  </div>

  <div class="row g-3">
    {{-- INFO TRANSAKSI --}}
    <div class="col-md-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6 class="text-muted text-uppercase small mb-3">Informasi Transaksi</h6>
          <dl class="row small mb-0">
            <dt class="col-4">ID</dt>
            <dd class="col-8">#{{ $sale->id }}</dd>

            <dt class="col-4">Tanggal</dt>
            <dd class="col-8">{{ \Carbon\Carbon::parse($sale->date)->format('d-m-Y H:i') }}</dd>

            <dt class="col-4">Kasir</dt>
            <dd class="col-8">{{ $sale->user->name ?? '-' }}</dd>

            <dt class="col-4">Total</dt>
            <dd class="col-8 fw-semibold h5 mb-0">
              Rp {{ number_format($sale->total,0,',','.') }}
            </dd>
          </dl>
        </div>
      </div>
    </div>

    {{-- DAFTAR ITEM --}}
    <div class="col-md-7">
      <div class="card shadow-sm">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
          <h6 class="mb-0">
            <i class="bi bi-bag-check me-1"></i> Daftar Item
          </h6>
          <span class="badge bg-light text-muted d-none d-print-inline">
            Total item: {{ $sale->items->sum('qty') }}
          </span>
        </div>
        <div class="card-body pt-2">
          <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th style="width:40px;">#</th>
                  <th>Obat</th>
                  <th class="text-center" style="width:70px;">Qty</th>
                  <th class="text-end" style="width:120px;">Harga</th>
                  <th class="text-end" style="width:140px;">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                @foreach($sale->items as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->medicine->name ?? '-' }}</td>
                    <td class="text-center">{{ $item->qty }}</td>
                    <td class="text-end">
                      Rp {{ number_format($item->price,0,',','.') }}
                    </td>
                    <td class="text-end">
                      Rp {{ number_format($item->price * $item->qty,0,',','.') }}
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="4" class="text-end">Total</th>
                  <th class="text-end fw-semibold">
                    Rp {{ number_format($sale->total,0,',','.') }}
                  </th>
                </tr>
              </tfoot>
            </table>
          </div>

          {{-- Catatan kecil di bawah struk (opsional, tetap tampak profesional) --}}
          <p class="small text-muted mt-3 mb-0 d-print-block">
            * Terima kasih telah berbelanja di Apotek {{ config('app.name', 'Laravel') }}.
          </p>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
