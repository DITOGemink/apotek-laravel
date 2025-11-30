<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $r)
    {
        $q = $r->q;
        $suppliers = Supplier::when($q, function($query) use ($q) {
            $query->where('name', 'like', "%{$q}%")
                  ->orWhere('address', 'like', "%{$q}%")
                  ->orWhere('phone', 'like', "%{$q}%");
        })->paginate(10);

        return view('suppliers.index', compact('suppliers'));
    }
    
    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name'    => 'required|min:3',
            'address' => 'nullable|string',
            'phone'   => 'nullable|string',
        ]);

        Supplier::create($data);

        return redirect()->route('suppliers.index')->with('ok','Supplier ditambahkan');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $r, Supplier $supplier)
    {
        $data = $r->validate([
            'name'    => 'required|min:3',
            'address' => 'nullable|string',
            'phone'   => 'nullable|string',
        ]);

        $supplier->update($data);

        return back()->with('ok','Supplier diperbarui');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return back()->with('ok','Supplier dihapus');
    }
    public function search(Request $r)
    {
        $q = $r->q;
        $suppliers = Supplier::where('name', 'like', "%{$q}%")
            ->orWhere('address', 'like', "%{$q}%")
            ->orWhere('phone', 'like', "%{$q}%")
            ->paginate(10);
        return view('suppliers.index', compact('suppliers', 'q'));
    }
}
