@extends('layouts.master')

@section('content')
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Daftar Obat</h1>
    <div>
      <a href="{{ route('medicines.create') }}" class="btn btn-primary btn-sm">+ Tambah Obat</a>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">

      {{-- Form Pencarian --}}
      <form class="row g-2 mb-3" method="GET" action="{{ route('medicines.search') }}">
        <div class="col-sm-6 col-md-4">
          <input type="text"
                 name="q"
                 value="{{ request('q') }}"
                 class="form-control form-control-sm"
                 placeholder="Cari nama / kategori...">
        </div>
        <div class="col-auto">
          <button class="btn btn-outline-secondary btn-sm" type="submit">Cari</button>
        </div>
        @if(request('q'))
          <div class="col-auto d-flex align-items-center">
            <a href="{{ route('medicines.index') }}" class="btn btn-link btn-sm p-0">Reset</a>
          </div>
        @endif
      </form>
      <p class="text-muted small mb-3">
        Tekan <span class="fw-semibold">Enter</span> atau klik <span class="fw-semibold">Cari</span> untuk mencari obat.
      </p>

      {{-- Tabel Obat --}}
      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
          <thead class="table-primary">
            <tr>
              <th>Nama</th>
              <th>Kategori</th>
              <th class="text-end">Harga</th>
              <th class="text-center">Stok</th>
              <th>Kadaluarsa</th>
              <th>Gambar</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
                   @forelse($medicines as $m)
            @php
              // warna baris berdasarkan stok
              $rowClass = $m->stock <= 10
                            ? 'table-danger'
                            : ($m->stock <= 30 ? 'table-warning' : '');

              // badge stok
              $stockClass = $m->stock <= 10
                              ? 'badge bg-danger'
                              : ($m->stock <= 30 ? 'badge bg-warning text-dark' : 'badge bg-success');
            @endphp

            <tr class="{{ $rowClass }}">
              <td>{{ $m->name }}</td>
              <td>{{ $m->category->name ?? '-' }}</td>

              {{-- Harga pakai badge biar lebih menonjol --}}
              <td class="text-end">
                <span class="badge bg-primary">
                  Rp {{ number_format($m->price,0,',','.') }}
                </span>
              </td>

              {{-- Stok: badge + warna baris sudah ikut dari $rowClass --}}
              <td class="text-center">
                <span class="{{ $stockClass }}">{{ $m->stock }}</span>
              </td>

              <td>{{ $m->exp_date ? \Carbon\Carbon::parse($m->exp_date)->format('d-m-Y') : '-' }}</td>

              <td>
                  @if($m->image_path)
                      <img src="{{ asset('storage/'.$m->image_path) }}"
                           alt="Gambar Obat"
                           style="width:80px; height:80px; object-fit:cover; border-radius:8px; cursor:zoom-in;"
                           onclick="previewImage('{{ asset('storage/'.$m->image_path) }}')">
                  @else
                      <span class="text-muted">Tidak ada</span>
                  @endif
              </td>

              <td class="text-end">
                <a href="{{ route('medicines.edit',$m) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                <form action="{{ route('medicines.destroy',$m) }}"
                      method="POST"
                      class="d-inline form-delete"
                      data-message="Yakin ingin menghapus obat '{{ $m->name }}'?">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-outline-danger btn-sm">Hapus</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center text-muted">Belum ada data obat.</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination (pakai kalau di controller sudah paginate) --}}
      @if(method_exists($medicines, 'links'))
        <div class="mt-3">
          {{ $medicines->links() }}
        </div>
      @endif

    </div>
  </div>
</div>
@endsection
