@extends('layouts.master')

@section('title','Buat Penjualan')

@section('content')
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">
      <i class="bi bi-receipt-cutoff me-1"></i> Buat Penjualan
    </h1>
    <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary btn-sm">
      <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      @if ($errors->any())
        <div class="alert alert-danger small">
          <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('sales.store') }}">
        @csrf

        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label class="form-label">Tanggal & Waktu</label>
            <input type="datetime-local"
                   name="date"
                   value="{{ old('date', now()->format('Y-m-d\TH:i')) }}"
                   class="form-control @error('date') is-invalid @enderror"
                   required>
            @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-8 d-flex align-items-end justify-content-end">
            <div class="text-end small text-muted">
              Pilih obat, atur qty, lalu simpan penjualan.
            </div>
          </div>
        </div>

        <div class="table-responsive mb-2">
          <table class="table table-sm align-middle" id="itemsTable">
            <thead class="table-light">
              <tr>
                <th style="width:30%">Obat</th>
                <th style="width:12%">Harga</th>
                <th style="width:12%">Stok</th>
                <th style="width:12%">Qty</th>
                <th style="width:16%">Subtotal</th>
                <th style="width:8%"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <select name="items[0][medicine_id]" class="form-select form-select-sm med-select" required>
                    <option value="">-- pilih obat --</option>
                    @foreach($medicines as $m)
                      <option value="{{ $m->id }}"
                              data-price="{{ $m->price }}"
                              data-stock="{{ $m->stock }}">
                        {{ $m->name }}
                      </option>
                    @endforeach
                  </select>
                </td>
                <td class="price">0</td>
                <td class="stock">0</td>
                <td>
                  <input type="number"
                         name="items[0][qty]"
                         value="1"
                         min="1"
                         class="form-control form-control-sm qty">
                </td>
                <td class="subtotal">0</td>
                <td class="text-end">
                  <button type="button" class="btn btn-sm btn-outline-danger remove">
                    <i class="bi bi-x-lg"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <button type="button" id="addRow" class="btn btn-secondary btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Baris
          </button>

          <div class="fs-5">
            <span class="text-muted">Total: </span>
            <strong>Rp <span id="grandTotal">0</span></strong>
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <button class="btn btn-primary">
            <i class="bi bi-check-circle me-1"></i> Simpan Penjualan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
function recalc(){
  let grand = 0;
  document.querySelectorAll('#itemsTable tbody tr').forEach(tr => {
    const price = Number(tr.querySelector('.price').textContent || 0);
    const qty   = Number(tr.querySelector('.qty').value || 0);
    const sub   = price * qty;
    tr.querySelector('.subtotal').textContent =
      new Intl.NumberFormat('id-ID').format(sub);
    grand += sub;
  });
  document.getElementById('grandTotal').textContent =
    new Intl.NumberFormat('id-ID').format(grand);
}

function bindRow(tr){
  const sel = tr.querySelector('.med-select');
  sel?.addEventListener('change', () => {
    const opt = sel.selectedOptions[0];
    tr.querySelector('.price').textContent = opt?.dataset.price || 0;
    tr.querySelector('.stock').textContent = opt?.dataset.stock || 0;
    tr.querySelector('.qty').value = 1;
    recalc();
  });

  tr.querySelector('.qty')?.addEventListener('input', () => {
    let val = Number(tr.querySelector('.qty').value || 0);
    if (val < 1) { val = 1; tr.querySelector('.qty').value = 1; }
    recalc();
  });

  tr.querySelector('.remove')?.addEventListener('click', () => {
    const rows = document.querySelectorAll('#itemsTable tbody tr').length;
    if (rows > 1) {
      tr.remove();
      recalc();
    }
  });
}

document.querySelectorAll('#itemsTable tbody tr').forEach(bindRow);

const tbody = document.querySelector('#itemsTable tbody');
document.getElementById('addRow').addEventListener('click', () => {
  const idx = tbody.querySelectorAll('tr').length;

  const tr = document.createElement('tr');
  tr.innerHTML = `
    <td>
      <select name="items[${idx}][medicine_id]" class="form-select form-select-sm med-select" required>
        <option value="">-- pilih obat --</option>
        @foreach($medicines as $m)
          <option value="{{ $m->id }}"
                  data-price="{{ $m->price }}"
                  data-stock="{{ $m->stock }}">
            {{ $m->name }}
          </option>
        @endforeach
      </select>
    </td>
    <td class="price">0</td>
    <td class="stock">0</td>
    <td>
      <input type="number"
             name="items[${idx}][qty]"
             value="1"
             min="1"
             class="form-control form-control-sm qty">
    </td>
    <td class="subtotal">0</td>
    <td class="text-end">
      <button type="button" class="btn btn-sm btn-outline-danger remove">
        <i class="bi bi-x-lg"></i>
      </button>
    </td>
  `;

  tbody.appendChild(tr);
  bindRow(tr);
  recalc();
});
</script>
@endsection
