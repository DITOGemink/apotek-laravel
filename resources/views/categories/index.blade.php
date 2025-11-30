@extends('layouts.master')

@section('content')
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Kategori</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">+ Tambah Kategori</a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">

      <form class="row g-2 mb-3" method="GET" action="{{ route('categories.index') }}">
        <div class="col-sm-4">
          <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari kategori...">
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
              <th>Nama Kategori</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categories as $cat)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $cat->name }}</td>
                <td class="text-end">
                  <a href="{{ route('categories.edit', $cat) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                  <form action="{{ route('categories.destroy', $cat) }}"
                      method="POST"
                      class="d-inline form-delete"
                      data-message="Yakin ingin menghapus kategori '{{ $cat->name }}'?">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-outline-danger btn-sm">Hapus</button>
                </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="text-center text-muted">Belum ada kategori.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if(method_exists($categories, 'links'))
        <div class="mt-3">
          {{ $categories->links() }}
        </div>
      @endif

    </div>
  </div>
</div>
@endsection
