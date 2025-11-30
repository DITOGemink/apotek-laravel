<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller 
{
  public function index(Request $r)
  {
      $q = $r->q;
      $categories = Category::when($q, function($query) use ($q) {
          $query->where('name', 'like', "%{$q}%");
      })->paginate(10);

      return view('categories.index', compact('categories'));
  }

  public function create(){ return view('categories.create'); }

  public function store(Request $r){
    $data = $r->validate(['name'=>'required|min:3']);
    Category::create($data);
    return redirect()->route('categories.index')->with('ok','Kategori ditambahkan');
  }

  public function edit(Category $category){ return view('categories.edit',compact('category')); }

  public function update(Request $r, Category $category){
    $data = $r->validate(['name'=>'required|min:3']);
    $category->update($data);
    return back()->with('ok','Kategori diperbarui');
  }

  public function destroy(Category $category){ $category->delete(); return back()->with('ok','Kategori dihapus'); }

  public function search(Request $r)
  {
      $q = $r->q;
      $categories = Category::where('name', 'like', "%{$q}%")->paginate(10);
      return view('categories.index', compact('categories', 'q'));
  }
}
