<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // penggunaan query builder

class KaryawanController extends Controller
{
    // Halaman index di view
    public function index()
    {
        // Mengambil data dari tabel karyawan
        $karyawan = DB::table('karyawan')->paginate(5); 

        // Mengirim data karyawan ke view
        return view('index', ['karyawan' => $karyawan]);
    }

    // Halaman tambah data
    public function tambah()
    {
        return view('tambah');
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        DB::table('karyawan')->insert([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'umur' => $request->umur,
            'alamat' => $request->alamat
        ]);

        return redirect('/karyawan');
    }

    // Mengedit data karyawan
    public function edit($id)
    {
        $karyawan = DB::table('karyawan')->where('karyawan_id', $id)->get();
        return view('edit', ['karyawan' => $karyawan]);
    }

    // Mengupdate data
    public function update(Request $request)
    {
        DB::table('karyawan')->where('karyawan_id', $request->id)->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'umur' => $request->umur,
            'alamat' => $request->alamat
        ]);

        return redirect('/karyawan');
    }

    // Menghapus data
    public function hapus($id)
    {
        DB::table('karyawan')->where('karyawan_id', $id)->delete();
        return redirect('/karyawan');
    }

    // Menampilkan laporan
    public function laporan()
    {
        $karyawan = DB::table('karyawan')->get();
        return view('laporan', ['karyawan' => $karyawan]);
    }
    public function cari(Request $request)
    {
        // menangkap data pencarian
        $cari = $request->cari;

        // mengambil data dari table karyawan sesuai pencarian data
        $pegawai = DB::table('karyawan')
            ->where('nama', 'like', "%" . $cari . "%")
            ->paginate();

        // mengirim data karyawan ke view index
        return view('index', ['karyawan' => $pegawai]);
    }

// ===================== CRUD BARANG =====================

    // Halaman index barang
    public function barangIndex()
    {
        $barang = DB::table('barang')->get();
        return view('barang_index', ['barang' => $barang]);
    }

    // Halaman tambah barang
    public function barangTambah()
    {
        return view('barang_tambah');
    }

    // Menyimpan data barang
    public function barangStore(Request $request)
    {
        DB::table('barang')->insert([
            'nama_barang' => $request->nama_barang,
            'jenis' => $request->jenis,
            'harga' => $request->harga,
            'stok' => $request->stok
        ]);

        return redirect('/barang');
    }

    // Halaman edit barang
    public function barangEdit($id)
    {
        $barang = DB::table('barang')->where('barang_id', $id)->get();
        return view('barang_edit', ['barang' => $barang]);
    }

    // Update data barang
    public function barangUpdate(Request $request)
    {
        DB::table('barang')->where('barang_id', $request->id)->update([
            'nama_barang' => $request->nama_barang,
            'jenis' => $request->jenis,
            'harga' => $request->harga,
            'stok' => $request->stok
        ]);

        return redirect('/barang');
    }

    // Hapus data barang
    public function barangHapus($id)
    {
        DB::table('barang')->where('barang_id', $id)->delete();
        return redirect('/barang');
    }
        // Cetak laporan barang
    public function laporanBarang()
    {
        $barang = DB::table('barang')->get();
        return view('laporan_barang', ['barang' => $barang]);
    }
}
