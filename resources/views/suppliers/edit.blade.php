@extends('layouts.master')

@section('title', 'Edit Supplier')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Edit Supplier</h1>
        <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary btn-sm">← Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Supplier</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $supplier->name) }}"
                           class="form-control @error('name') is-invalid @enderror"
                           required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text"
                           name="address"
                           value="{{ old('address', $supplier->address) }}"
                           class="form-control @error('address') is-invalid @enderror"
                           required>
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Telp</label>
                    <input type="text"
                           name="phone"
                           value="{{ old('phone', $supplier->phone) }}"
                           class="form-control @error('phone') is-invalid @enderror"
                           required>
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
