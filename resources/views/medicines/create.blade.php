@extends('layouts.master')

@section('title', 'Tambah Obat')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Tambah Obat</h1>
        <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary btn-sm">← Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('medicines.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        {{-- Nama --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Obat</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Kategori --}}
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Harga --}}
                        <div class="mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number"
                                   name="price"
                                   value="{{ old('price') }}"
                                   class="form-control @error('price') is-invalid @enderror"
                                   min="0"
                                   required>
                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Stok --}}
                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number"
                                   name="stock"
                                   value="{{ old('stock') }}"
                                   class="form-control @error('stock') is-invalid @enderror"
                                   min="0"
                                   required>
                            @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Kadaluarsa --}}
                        <div class="mb-3">
                            <label class="form-label">Tanggal Kadaluarsa</label>
                            <input type="date"
                                   name="exp_date"
                                   value="{{ old('exp_date') }}"
                                   class="form-control @error('exp_date') is-invalid @enderror">
                            @error('exp_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                  <div class="mb-3">
                    <label class="form-label">Gambar Obat</label>
                    <input type="file"
                           name="image"
                           class="form-control @error('image') is-invalid @enderror"
                           accept="image/*"
                           onchange="previewNewImage(event)">
                    @error('image')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="mt-2">
                      <img id="preview-new-image"
                           src="https://via.placeholder.com/120x120?text=Preview"
                           class="rounded border"
                           style="width:120px;height:120px;object-fit:cover;">
                    </div>
                  </div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@section('scripts')
<script>
  function previewNewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview-new-image');

    if (!input.files || !input.files[0]) return;

    const file = input.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
      preview.src = e.target.result;
    };

    reader.readAsDataURL(file);
  }
</script>
@endsection

@endsection
