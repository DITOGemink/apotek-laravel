<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Models\Category;


class MedicineController extends Controller
{
  public function index(){
    $medicines = Medicine::with('category')->paginate(10);
    return view('medicines.index', compact('medicines'));
  }

  public function create(){
    return view('medicines.create', ['categories'=>Category::all()]);
  }

  public function store(Request $r){
    $data = $r->validate([
      'name'=>'required|min:3','price'=>'required|numeric|min:0',
      'stock'=>'required|integer|min:0','exp_date'=>'nullable|date',
      'category_id'=>'required|exists:categories,id','image'=>'nullable|image|max:2048'
    ]);
    if($r->hasFile('image')){
      $data['image_path'] = $r->file('image')->store('medicines','public');
    }
    Medicine::create($data);
    return redirect()->route('medicines.index')->with('ok','Obat ditambahkan');
  }

  public function edit(Medicine $medicine){
    return view('medicines.edit', ['medicine'=>$medicine,'categories'=>Category::all()]);
  }

  public function update(Request $r, Medicine $medicine){
    $data = $r->validate([
      'name'=>'required|min:3','price'=>'required|numeric|min:0',
      'stock'=>'required|integer|min:0','exp_date'=>'nullable|date',
      'category_id'=>'required|exists:categories,id','image'=>'nullable|image|max:2048'
    ]);
    if($r->hasFile('image')){
      $data['image_path'] = $r->file('image')->store('medicines','public');
    }
    $medicine->update($data);
    return back()->with('ok','Obat diperbarui');
  }

  public function destroy(Medicine $medicine){
    $medicine->delete(); return back()->with('ok','Obat dihapus');
  }

  // Pencarian
  public function search(Request $r){
    $q = $r->q;
    $medicines = Medicine::with('category')
      ->where('name','like',"%{$q}%")
      ->orWhereHas('category', fn($w)=>$w->where('name','like',"%{$q}%"))
      ->paginate(10);
    return view('medicines.index', compact('medicines','q'));
  }

  // Laporan
  public function report(){
    $medicines = Medicine::with('category')->get();
    return view('medicines.report', compact('medicines'));
  }
}

