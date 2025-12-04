@extends('layouts.master')

@section('title','Daftar Transaksi')

@section('content')
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">
      <i class="bi bi-receipt me-1"></i> Daftar Transaksi
    </h1>
    <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm">
      <i class="bi bi-plus-circle me-1"></i> Buat Penjualan
    </a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      @if($sales->isEmpty())
        <p class="mb-0 text-muted">Belum ada transaksi.</p>
      @else
        <div class="table-responsive">
          <table class="table table-sm align-middle table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th style="width:60px;">#</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th class="text-end">Total</th>
                <th class="text-end">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($sales as $s)
                <tr>
                  <td>{{ $s->id }}</td>
                  <td>{{ \Carbon\Carbon::parse($s->date)->format('d-m-Y H:i') }}</td>
                  <td>{{ $s->user->name ?? '-' }}</td>
                  <td class="text-end">
                    Rp {{ number_format($s->total,0,',','.') }}
                  </td>
                  <td class="text-end">
                    <a href="{{ route('sales.show',$s) }}" class="btn btn-sm btn-outline-primary">
                      Detail
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

          @if(method_exists($sales, 'links'))
            <div class="d-flex justify-content-between align-items-center mt-3">
              <div class="text-muted">
                Showing {{ $sales->firstItem() ?? 0 }} to {{ $sales->lastItem() ?? 0 }} of {{ $sales->total() ?? 0 }} results
              </div>
              <div>
                {!! $sales->links('pagination::bootstrap-5') !!}
              </div>
            </div>
          @endif

    </div>
  </div>
</div>
@endsection
