@extends('layouts.master')

@section('content')
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">
      <i class="bi bi-speedometer2 me-1"></i> Kasir Dashboard
    </h1>
    <div class="d-flex gap-2">
      <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Buat Transaksi
      </a>
      <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
        <i class="bi bi-bag-plus me-1"></i> Daftar Obat
      </a>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-2">
            <div>
              <div class="small text-muted mb-1">Quick Info</div>
              <div class="fw-semibold">{{ auth()->user()->name }}</div>
              <span class="badge rounded-pill bg-primary-subtle text-primary mt-1">
                <i class="bi bi-person-badge me-1"></i> Kasir
              </span>
            </div>
            <div class="text-muted">
              <i class="bi bi-cash-stack fs-2"></i>
            </div>
          </div>
          <p class="mb-0 small text-muted">
            Gunakan tombol <span class="fw-semibold">Buat Transaksi</span> untuk mencatat penjualan dengan cepat.
          </p>
        </div>

      <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-star me-1 text-warning"></i> Obat Terlaris (5 besar)</span>
      </div>
      <div class="card-body">
        @if($topMedicines->isEmpty())
          <p class="mb-0 text-muted">Belum ada data obat.</p>
        @else
          <ol class="mb-0 ps-3">
            @foreach($topMedicines as $t)
              <li class="mb-1">
                <span class="fw-semibold">{{ $t['name'] }}</span>
                <span class="badge bg-primary-subtle text-primary ms-1">{{ $t['qty'] }} pcs</span>
              </li>
            @endforeach
          </ol>
        @endif
      </div>
      </div>
    </div>
    <div class="col-md-6">
      {{-- KARTU: DAFTAR OBAT SINGKAT --}}
      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="card-title mb-0">
              <i class="bi bi-capsule me-2 text-primary"></i> Daftar Obat Singkat
            </h6>
          </div>

          @php
            $list = \App\Models\Medicine::orderBy('name')->limit(6)->get();
          @endphp

          @if($list->isEmpty())
            <p class="mb-0 text-muted">Belum ada obat.</p>
          @else
            <table class="table table-sm align-middle mb-2 table-hover">
              <thead class="table-light">
                <tr>
                  <th>Nama</th>
                  <th class="text-end">Stok</th>
                </tr>
              </thead>
              <tbody>
                @foreach($list as $m)
                  @php
                    $stock = $m->stock;
                    $badgeClass =
                      $stock <= 5  ? 'bg-danger-subtle text-danger' :
                      ($stock <= 15 ? 'bg-warning-subtle text-warning' :
                                      'bg-success-subtle text-success');
                  @endphp
                  <tr>
                    <td>{{ strtoupper($m->name) }}</td>
                    <td class="text-end">
                      <span class="badge rounded-pill mini-stock-pill {{ $badgeClass }}">
                        {{ $stock }} pcs
                      </span>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <div class="text-end mini-link-all">
              <a href="{{ route('medicines.index') }}" class="text-decoration-none">
                Lihat semua obat <span class="ms-1">→</span>
              </a>
            </div>
          @endif
        </div>
      </div>

      {{-- KARTU: TRANSAKSI TERAKHIR --}}
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="card-title mb-0">
              <i class="bi bi-receipt-cutoff me-2 text-success"></i> Transaksi Terakhir
            </h6>
          </div>

          @php
            $recent = \App\Models\Sale::with('user')->orderByDesc('date')->limit(5)->get();
          @endphp

          @if($recent->isEmpty())
            <p class="mb-0 text-muted">Belum ada transaksi.</p>
          @else
            @foreach($recent as $s)
              <div class="mini-transaction px-3 py-2 mb-2 d-flex justify-content-between align-items-center">
                <div>
                  <div class="fw-semibold">#{{ $s->id }}</div>
                  <small class="text-muted">
                    <i class="bi bi-calendar-event me-1"></i>
                    {{ \Carbon\Carbon::parse($s->date)->format('d M Y H:i') }}
                  </small>
                </div>
                <div class="text-end">
                  <div class="fw-semibold text-success">
                    Rp {{ number_format($s->total, 0, ',', '.') }}
                  </div>
                  <a href="{{ route('sales.show',$s) }}"
                     class="btn btn-sm btn-outline-primary rounded-pill mt-1">
                    Detail
                  </a>
                </div>
              </div>
            @endforeach

            <div class="text-end mini-link-all mt-2">
              <a href="{{ route('sales.index') }}" class="text-decoration-none">
                Lihat semua transaksi <span class="ms-1">→</span>
              </a>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
