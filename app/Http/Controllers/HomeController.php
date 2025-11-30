<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Models\Student; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Models\Medicine;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    // // Pastikan halaman ini hanya untuk user yang login
    // public function __construct()
    // {
    //     $this->middleware('auth')->only(['index', 'update_password', 'store_password']);
    // }

public function index()
{
    if (auth()->check()) {
        $role = auth()->user()->role;

        if ($role === 'admin') {
            // admin tetap diarahkan ke dashboard admin
            return redirect()->route('admin.dashboard');
        }

        if ($role === 'kasir') {
            // DATA UNTUK DASHBOARD KASIR

            // daftar obat singkat (6 obat pertama urut nama)
            $list = Medicine::orderBy('name')->limit(6)->get();

            // transaksi terakhir (5 transaksi terbaru)
            $recent = Sale::with('user')
                ->orderByDesc('date')
                ->limit(5)
                ->get();

            // top 5 obat terlaris (boleh pakai logika yang sama dengan admin)
            $topMedicines = DB::table('sale_items')
                ->select('medicine_id', DB::raw('SUM(qty) as total_qty'))
                ->groupBy('medicine_id')
                ->orderByDesc('total_qty')
                ->limit(5)
                ->get()
                ->map(function($row){
                    $m = Medicine::find($row->medicine_id);
                    return [
                        'name' => $m ? $m->name : '—',
                        'qty'  => $row->total_qty
                    ];
                });

            return view('kasir.dashboard', compact('list', 'recent', 'topMedicines'));
        }
    }

    // halaman publik/default
    return view('home');
}

    public function update_password()
    {
        $user = Auth::user();
        return view('update_password', compact('user'));
    }

    public function store_password(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:8|confirmed',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        $request->session()->flash('message', 'Successfully changed password');
        return Redirect::back();
    }
  
    public function dashboard()
    {
        // ringkasan angka
        $totalMedicines = \App\Models\Medicine::count();
        $totalSuppliers = \App\Models\Supplier::count();
        $totalSalesToday = \App\Models\Sale::whereDate('date', today())->count();
        $totalRevenueToday = \App\Models\Sale::whereDate('date', today())->sum('total');

        // obat stok rendah (contoh ambang 10)
        $lowStock = \App\Models\Medicine::where('stock', '<=', 10)->orderBy('stock')->get();

        // 5 transaksi terakhir
        $recentSales = \App\Models\Sale::with('items.medicine','user')
                          ->orderByDesc('date')
                          ->limit(5)
                          ->get();

        // omzet 7 hari (label + data) untuk Chart.js
        $labels = [];
        $revenues = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $labels[] = $day->format('d M');
            $revenues[] = \App\Models\Sale::whereDate('date', $day)->sum('total');
        }

        // top 5 obat terlaris (sum qty from sale_items)
        $topMedicines = \Illuminate\Support\Facades\DB::table('sale_items')
            ->select('medicine_id', \Illuminate\Support\Facades\DB::raw('SUM(qty) as total_qty'))
            ->groupBy('medicine_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get()
            ->map(function($row){
                $m = \App\Models\Medicine::find($row->medicine_id);
                return [
                    'name' => $m ? $m->name : '—',
                    'qty'  => $row->total_qty
                ];
            });

        return view('admin.dashboard', compact(
            'totalMedicines','totalSuppliers','totalSalesToday','totalRevenueToday',
            'lowStock','recentSales','labels','revenues','topMedicines'
        ));
    }
}
