@extends('layouts.master')

@section('title','Admin Dashboard')

@section('head')
<style>
  .list-group-item {
    transition: .2s;
  }
  .list-group-item:hover {
    background-color: #f8f9fa;
  }
</style>
@endsection

@section('content')

<div class="card shadow-sm mb-4">
  <div class="card-body">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h1 class="h3 mb-1">Admin Dashboard</h1>
        <p class="text-muted mb-0">Ringkasan aktivitas apotek hari ini</p>
      </div>

      <div class="btn-group">
        <a href="{{ route('medicines.index') }}" class="btn btn-primary btn-sm">
          <i class="bi bi-bag-plus me-1"></i> Kelola Obat
        </a>
        <a href="{{ route('sales.index') }}" class="btn btn-outline-primary btn-sm">
          <i class="bi bi-receipt me-1"></i> Transaksi
        </a>
      </div>
    </div>

    {{-- STAT BOXES --}}
    <div class="row g-3 mb-3">
      <div class="col-md-3">
        <div class="card shadow-sm stat-card border-0 h-100">
          <div class="card-body d-flex align-items-center">
            <div class="me-3">
              <i class="bi bi-bag-check fs-1 text-primary"></i>
            </div>
            <div>
              <small class="text-muted">Total Obat</small>
              <div class="h3 fw-bold mb-0">{{ $totalMedicines }}</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card shadow-sm stat-card border-0 h-100">
          <div class="card-body d-flex align-items-center">
            <div class="me-3">
              <i class="bi bi-truck fs-1 text-primary"></i>
            </div>
            <div>
              <small class="text-muted">Total Supplier</small>
              <div class="h3 fw-bold mb-0">{{ $totalSuppliers }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- MAIN ROW --}}
    <div class="row g-3">
      <div class="col-lg-6">

        {{-- STOK RENDAH --}}
        <div class="card shadow-sm mb-3">
          <div class="card-header bg-white fw-semibold border-0">
            <i class="bi bi-exclamation-triangle me-1 text-danger"></i>
            Obat Stok Rendah (≤ 10)
          </div>
          <div class="card-body">
            @if($lowStock->isEmpty())
              <p class="mb-0 text-muted">Tidak ada obat stok rendah.</p>
            @else
              <ul class="list-group">
                @foreach($lowStock as $m)
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $m->name }}
                    <span class="badge bg-danger">{{ $m->stock }}</span>
                  </li>
                @endforeach
              </ul>
            @endif
            <div class="mt-3">
              <a href="{{ route('medicines.index') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-box-arrow-up-right me-1"></i> Kelola Obat
              </a>
            </div>
          </div>
        </div>

        {{-- TOP 5 OBAT TERLARIS --}}
        <div class="card shadow-sm">
          <div class="card-header bg-white fw-semibold border-0">
            <i class="bi bi-bar-chart-line me-1 text-primary"></i>
            Top 5 Obat Terlaris
          </div>
          <div class="card-body">
            @if($topMedicines->isEmpty())
              <p class="mb-0 text-muted">Belum ada penjualan.</p>
            @else
              <ol class="mb-0">
                @foreach($topMedicines as $t)
                  <li>{{ $t['name'] }} — {{ $t['qty'] }} pcs</li>
                @endforeach
              </ol>
            @endif
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        {{-- GRAFIK OMZET --}}
        <div class="card shadow-sm mb-3">
          <div class="card-header bg-white fw-semibold border-0">
            <i class="bi bi-graph-up me-1 text-success"></i>
            Grafik Omzet 7 Hari
          </div>
          <div class="card-body" style="min-height:260px;">
            <canvas id="revenueChart" height="220"></canvas>
          </div>
        </div>

        {{-- TRANSAKSI TERBARU --}}
        <div class="card shadow-sm">
          <div class="card-header bg-white fw-semibold border-0">
            <i class="bi bi-receipt me-1 text-primary"></i>
            Transaksi Terbaru
          </div>
          <div class="card-body">
            @if($recentSales->isEmpty())
              <p class="mb-0 text-muted">Belum ada transaksi.</p>
            @else
              <table class="table table-sm mb-0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th class="text-end">Total</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($recentSales as $s)
                    <tr>
                      <td>{{ $s->id }}</td>
                      <td>{{ \Carbon\Carbon::parse($s->date)->format('d-m-Y H:i') }}</td>
                      <td class="text-end">Rp {{ number_format($s->total,0,',','.') }}</td>
                      <td>
                        <a href="{{ route('sales.show',$s) }}" class="btn btn-sm btn-outline-primary">
                          Detail
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            @endif
          </div>
        </div>

      </div>
    </div>

  </div> {{-- /.card-body --}}
</div>   {{-- /.card --}}

@endsection

@section('scripts')
<script>
  const labels   = {!! json_encode($labels) !!};
  const revenues = {!! json_encode($revenues) !!}.map(v => Number(v) || 0);
  const ctxEl    = document.getElementById('revenueChart');

  if (ctxEl) {
    const allZero = revenues.every(v => v === 0);
    if (allZero) {
      ctxEl.style.display = 'none';
      const msg = document.createElement('div');
      msg.className = 'no-data-chart';
      msg.textContent = 'Belum ada transaksi untuk 7 hari terakhir';
      ctxEl.parentElement.appendChild(msg);
        } else {
      const ctx = ctxEl.getContext('2d');
      const formatRp = v => 'Rp ' + Number(v).toLocaleString('id-ID');

      // cari omzet terbesar lalu kasih “nafas” 10%
      const maxRevenue = Math.max(...revenues);
      const yMax = maxRevenue > 0 ? maxRevenue * 1.1 : 100000;

      new Chart(ctx, {
        type: 'line',
        data: {
          labels,
          datasets: [{
            label: 'Omzet (Rp)',
            data: revenues,
            tension: 0.3,
            fill: true,
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          layout: {
            padding: { top: 5, bottom: 5 }
          },
          plugins: {
            legend: { display: false },
            tooltip: {
              callbacks: {
                label: ctx => formatRp(ctx.raw ?? ctx.parsed.y)
              }
            }
          },
          scales: {
            y: {
              min: 0,
              max: yMax,
              ticks: {
                callback: value => formatRp(value)
              }
            }
          }
        }
      });
    }
  }
</script>
@endsection
