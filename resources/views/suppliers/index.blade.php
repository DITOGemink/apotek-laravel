@extends('layouts.master')

@section('content')
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Supplier</h1>
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-sm">+ Tambah Supplier</a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">

      
      <form class="row g-2 mb-3" method="GET" action="{{ route('suppliers.index') }}">
        <div class="col-sm-4">
          <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari nama / alamat...">
        </div>
        <div class="col-auto">
          <button class="btn btn-outline-secondary btn-sm">Cari</button>
        </div>
      </form>
      
      <div class="table-responsive">
        <table class="table table-sm align-middle table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th style="width:60px;">#</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Telp</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($suppliers as $sup)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $sup->name }}</td>
                <td>{{ $sup->address }}</td>
                <td>
                  <span class="badge bg-info text-dark">
                    <i class="bi bi-telephone me-1"></i>{{ $sup->phone }}
                  </span>
                </td>
                <td class="text-end">
                  <a href="{{ route('suppliers.edit', $sup) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                  <form action="{{ route('suppliers.destroy', $sup) }}"
                        method="POST"
                        class="d-inline form-delete"
                        data-message="Yakin ingin menghapus supplier '{{ $sup->name }}'?">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm">Hapus</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted">Belum ada supplier.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if(method_exists($suppliers, 'links'))
        <div class="mt-3">
          {{ $suppliers->links() }}
        </div>
      @endif

    </div>
  </div>
</div>
@endsection
