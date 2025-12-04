<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Apotek')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <style>
    /* background keseluruhan agak abu-abu lembut */
    body {
      background-color: #f8f9fa;
    }

    /* judul & lebar container biar terasa lega */
    h1, h3, h4 {
      font-weight: 600;
      letter-spacing: .3px;
    }

    .container {
      max-width: 1350px;
    }

    /* spacing & card look sederhana tapi rapi */
    .card .card-body .display-6 { font-size: 2.2rem; font-weight: 600; }

    .card {
      border-radius: .75rem;
      border: none;
      transition: .2s;
    }

    /* efek hover halus di semua card (dashboard kelihatan lebih hidup) */
    .card:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(0,0,0,.08);
    }

    .small-muted { color: #6c757d; }

    .no-data-chart {
      display:flex; align-items:center; justify-content:center;
      height:240px; color:#6c757d; font-weight:600;
    }

    /* tabel lebih rapi & ada hover */
    .table {
      border-radius: .5rem;
      overflow: hidden;
    }

    .table > :not(caption) > * > * {
      padding: .75rem 1rem;
    }

    .table-hover tbody tr:hover {
      background-color: #f2f6ff;
    }

    /* tombol ada animasi dikit */
    .btn {
      transition: .2s;
    }

    .btn:hover {
      transform: translateY(-2px);
    }

    @media (max-width:768px){
      .card .card-body .display-6 { font-size:1.6rem; }
    }
    .toast-container {
      position: fixed;
      top: 1rem;
      right: 1rem;
      z-index: 1080;
    }
    .stat-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 22px rgba(0, 0, 0, 0.12);
    }
    .navbar .nav-link.active {
      font-weight: 600;
      color: #0d6efd !important;
    }
    /* --- Kasir Dashboard: list mini warna-warni --- */
    .mini-stock-pill {
      font-size: .75rem;
      padding: .2rem .6rem;
    }

    .mini-link-all {
      font-size: .85rem;
    }

    .mini-transaction {
      background-color: #ffffff;
      transition: .2s;
      border-radius: .75rem;
    }

    .mini-transaction:hover {
      background-color: #f2f6ff;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0,0,0,.06);
    }

*** Begin Patch
*** Update File: resources/views/layouts/master.blade.php
@@
     /* Hide decorative/big svgs on small screens if needed */
     @media (max-width: 768px) {
       .page-decor, .hero-decor, .decorative-svg { display: none !important; }
     }
 
+    /* ---------- Strong fix for oversized SVG icons (pagination / buttons / nav) ---------- */
+    /* Target many possible pagination / inline-flex / anchor cases so svg does not scale huge */
+    .pagination svg,
+    .page-link svg,
+    .page-item svg,
+    .navbar svg,
+    .btn svg,
+    a svg,
+    button svg,
+    svg.w-5, svg.h-5,
+    a[class*="relative"] svg,
+    span[class*="relative"] svg,
+    a[rel="next"] svg,
+    a[rel="prev"] svg,
+    a[href*="?page="] svg,
+    a[class*="page"] svg {
+      width: 1.25rem !important;    /* 20px */
+      height: 1.25rem !important;   /* 20px */
+      max-width: 1.25rem !important;
+      max-height: 1.25rem !important;
+      display: inline-block;
+      vertical-align: middle;
+    }
+
+    /* Reduce clickable area of pagination anchors so SVG doesn't make huge clickable zone */
+    a[href*="?page="], a[rel="next"], a[rel="prev"], .page-link {
+      padding: .25rem .4rem !important;
+    }
+
+    /* If there are intentionally large decorative svgs, mark them with .svg-hero to exclude */
+    svg.svg-hero { width: auto !important; height: auto !important; max-width: none !important; }
+
*** End Patch


  </style>

  @yield('head')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm mb-3">
  <div class="container">

    {{-- Brand kiri atas --}}
    @if(auth()->check())
        @if(auth()->user()->role === 'admin')
            <a class="navbar-brand fw-semibold" href="{{ route('admin.dashboard') }}">
              <i class="bi bi-capsule me-1"></i> Apotek
            </a>
        @else
            <a class="navbar-brand fw-semibold" href="{{ route('home') }}">
              <i class="bi bi-capsule me-1"></i> Apotek
            </a>
        @endif
    @else
        <a class="navbar-brand fw-semibold" href="{{ route('home') }}">
          <i class="bi bi-capsule me-1"></i> Apotek
        </a>
    @endif

    {{-- Toggler mobile --}}
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav me-auto">
        @auth
          @if(auth()->user()->role === 'admin')
            {{-- MENU UNTUK ADMIN --}}
              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('medicines.*') ? 'active' : '' }}" href="{{ route('medicines.index') }}">
                  <i class="bi bi-bag-plus me-1"></i>Obat
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                  <i class="bi bi-tags me-1"></i>Kategori
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                  <i class="bi bi-truck me-1"></i>Supplier
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('medicines.report') ? 'active' : '' }}" href="{{ route('medicines.report') }}">
                  <i class="bi bi-file-earmark-text me-1"></i>Cetak Laporan
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                  <i class="bi bi-receipt me-1"></i>Transaksi
                </a>
              </li>

          @elseif(auth()->user()->role === 'kasir')
            {{-- MENU UNTUK KASIR --}}
              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}" href="{{ route('sales.create') }}">
                  <i class="bi bi-receipt me-1"></i>Transaksi
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('medicines.*') ? 'active' : '' }}" href="{{ route('medicines.index') }}">
                  <i class="bi bi-bag-plus me-1"></i>Obat
                </a>
              </li>

          @endif
        @endauth
      </ul>

      <ul class="navbar-nav ms-auto">
        @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="{{ route('update_password') }}">
                  <i class="bi bi-key me-1"></i> Ganti Password
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}" class="px-3">
                  @csrf
                  <button class="btn btn-link p-0">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                  </button>
                </form>
              </li>
            </ul>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
{{-- Toast sukses --}}
@if(session('ok'))
  <div class="toast-container">
    <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true" id="flashToast">
      <div class="d-flex">
        <div class="toast-body">
          <i class="bi bi-check-circle-fill me-2"></i>{{ session('ok') }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
@endif

{{-- (opsional) Toast error – tinggal pakai session('error') di controller kalau mau --}}
@if(session('error'))
  <div class="toast-container">
    <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true" id="errorToast">
      <div class="d-flex">
        <div class="toast-body">
          <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
@endif

<div class="container">
  @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toastEl = document.getElementById('flashToast');
    if (toastEl) {
      const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
      toast.show();
    }
    const errorEl = document.getElementById('errorToast');
    if (errorEl) {
    const toastErr = new bootstrap.Toast(errorEl, { delay: 4000 });
    toastErr.show();
   }
  });
</script>

{{-- Modal konfirmasi hapus global --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white py-2">
        <h6 class="modal-title mb-0">
          <i class="bi bi-exclamation-triangle-fill me-1"></i> Konfirmasi Hapus
        </h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="mb-0">
          <span class="confirm-message">Yakin ingin menghapus data ini?</span>
        </p>
      </div>
      <div class="modal-footer py-2">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-sm btn-danger btn-confirm-delete">
          Ya, Hapus
        </button>
      </div>
    </div>
  </div>
</div>


{{-- Modal preview gambar global --}}
<div class="modal fade" id="previewModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-2 bg-transparent border-0">
      <img id="preview-img" class="w-100 rounded">
    </div>
  </div>
</div>

<script>
  function previewImage(src) {
    const img = document.getElementById("preview-img");
    if (img) img.src = src;
    const modal = new bootstrap.Modal(document.getElementById("previewModal"));
    modal.show();
  }
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // toast sukses & error (kalau ada)
    const toastEl = document.getElementById('flashToast');
    if (toastEl) {
      const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
      toast.show();
    }
    const errorEl = document.getElementById('errorToast');
    if (errorEl) {
      const toastErr = new bootstrap.Toast(errorEl, { delay: 4000 });
      toastErr.show();
    }

    // === Modal konfirmasi hapus ===
    const deleteModalEl = document.getElementById('confirmDeleteModal');
    if (!deleteModalEl) return;

    const deleteModal = new bootstrap.Modal(deleteModalEl);
    let formToSubmit = null;

    document.querySelectorAll('form.form-delete').forEach(form => {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        formToSubmit = form;

        const msg = form.dataset.message || 'Yakin ingin menghapus data ini?';
        document.getElementById('confirmDeleteMessage').textContent = msg;

        deleteModal.show();
      });
    });

    document.getElementById('btn-confirm-delete')?.addEventListener('click', function () {
      if (formToSubmit) {
        formToSubmit.submit();
      }
    });
  });
</script>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title">
          <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
          Konfirmasi Hapus
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p id="confirmDeleteMessage" class="mb-0">
          Yakin ingin menghapus data ini?
        </p>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
          Batal
        </button>
        <button type="button" class="btn btn-danger btn-sm" id="btn-confirm-delete">
          Ya, Hapus
        </button>
      </div>
    </div>
  </div>
</div>

@yield('scripts')
</body>
</html>

