<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        // daftar penjualan terbaru, paginate
        $sales = Sale::with('items')->orderByDesc('date')->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        // kirim daftar obat untuk dipilih di form
        $medicines = Medicine::orderBy('name')->get(['id','name','price','stock']);
        return view('sales.create', compact('medicines'));
    }

    public function store(Request $r)
    {
        // validasi dasar form
        $data = $r->validate([
            'date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        DB::transaction(function() use ($data) {
            $sale = Sale::create([
                'user_id' => auth()->id(),
                'date'    => $data['date'],
                'total'   => 0,
            ]);

            $total = 0;

            foreach ($data['items'] as $row) {
                $med = Medicine::lockForUpdate()->findOrFail($row['medicine_id']); // kunci stok

                // Cegah stok minus
                if ($med->stock < $row['qty']) {
                    abort(422, "Stok {$med->name} tidak cukup (tersisa {$med->stock}).");
                }

                $lineTotal = $med->price * (int)$row['qty'];

                // simpan item
                $sale->items()->create([
                    'medicine_id' => $med->id,
                    'qty'         => (int)$row['qty'],
                    'price'       => $med->price, // snapshot harga saat transaksi
                ]);

                // kurangi stok
                $med->decrement('stock', (int)$row['qty']);

                $total += $lineTotal;
            }

            $sale->update(['total' => $total]);
        });

        return redirect()->route('sales.index')->with('ok','Transaksi berhasil disimpan');
    }

    public function show(Sale $sale)
    {
        $sale->load(['items.medicine']);
        return view('sales.show', compact('sale'));
    }
}
