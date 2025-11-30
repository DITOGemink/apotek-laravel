<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    // tambahkan ini — daftar kolom yang boleh di-mass assign
    protected $fillable = [
        'name',
        'address',
        'phone',
    ];

    // jika kamu butuh relasi, tambahkan method relasi di sini
}
