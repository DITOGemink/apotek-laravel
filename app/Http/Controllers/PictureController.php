<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Picture;

class PictureController extends Controller
{
    public function create(){
        return view('create_picture');
    }

    public function store(Request $request)
    {
        $file = $request->file('file');
        $name = $request->name;

        // Buat nama file unik
        $path = time() . '_' . $name . '.' . $file->getClientOriginalExtension();

        Storage::disk('public')->put($path, file_get_contents($file));

        // Simpan path ke database
        Picture::create([
            'name' => $name,
            'path' => $path,
        ]);

        return Redirect::route('picture.create');
    }

    public function show(Picture $picture)
    {
        $url = Storage::url($picture->path);
        return view('show_picture', compact('picture', 'url'));
    }

    public function delete(Picture $picture)
    {
        Storage::disk('public')->delete($picture->path);
        $picture->delete();

        return Redirect::route('picture.create');
    }

    public function copy(Picture $picture)
    {
        Storage::disk('public')->copy($picture->path, 'copy/'. $picture->path);
        return Redirect::route('picture.create');
    }
    public function move(Picture $picture)
    {
        Storage::disk('public')->move($picture->path, 'move/'. $picture->path);
        return Redirect::route('picture.create');
    }
}