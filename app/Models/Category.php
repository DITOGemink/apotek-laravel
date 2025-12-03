<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // tambahkan ini
    protected $fillable = [
        'name',
        // tambahkan kolom lain yang boleh di-mass-assign jika perlu
    ];

    // ... sisa model
}
